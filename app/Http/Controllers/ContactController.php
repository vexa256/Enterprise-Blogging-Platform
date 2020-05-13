<?php

namespace App\Http\Controllers;

use App\Categories;
use App\Contacts;
use App\Mail\ContactMail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function index()
    {
        $labels = Categories::byType('maillabel')->pluck('name', 'id');

        return view('_contact.contactpage', compact('labels'));
    }

    public function create(Request $request)
    {
        $inputs = $request->all();

        // incase if $thumb then tuse save button. we need to save image for that
        try {
            $validator = $this->validator($inputs);

            if ($validator->fails()) {
                throw new \Exception($validator->errors()->first());
            }

            $cat = Categories::byType('mailcat')->where('name_slug', 'inbox')->first();
            $contact = new Contacts;
            $contact->name = $inputs['name'];
            $contact->email = $inputs['email'];
            $contact->subject = $inputs['subject'];
            $contact->text = $inputs['text'];
            $contact->category_id = $cat->id;
            $contact->label_id = $inputs['label'];
            $contact->read = 0;
            $contact->save();

            $this->sendCopyEmail($contact);

            \Session::flash('success.message', trans('buzzycontact.successgot'));
            return redirect('/');
        } catch (\Exception $e) {
            \Session::flash('error.message', $e->getMessage());
            return redirect()->back()->withInput($inputs);
        }
    }

    public function sendCopyEmail(Contacts $contact)
    {
        try {
            $composeto = get_buzzy_config('BuzzyContactCopyEmail');
            if ($composeto > "") {
                Mail::to($composeto)->send(new ContactMail($contact));
            }
        } catch (\Exception $e) {
            // no error
        }
    }

    public function validator($inputs)
    {
        $rules = [
            'name'      => 'required',
            'email'     => 'required|email',
            'subject'   => 'required|min:5|max:255',
            'text'      => 'required|max:1500',
            'label'     => 'required',
        ];
        if (get_buzzy_config('BuzzyContactCaptcha') == "on") {
            $rules = array_merge($rules, [
                'g-recaptcha-response' => 'required|recaptcha'
            ]);
        }

        return \Validator::make($inputs, $rules);
    }
}
