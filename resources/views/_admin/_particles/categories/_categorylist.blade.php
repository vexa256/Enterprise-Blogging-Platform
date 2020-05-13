@if($altcategories!==null)
<table class="table table-striped">
    <tbody><tr style="border:0;    color: #9a9a9a;">
        <th style="width: 10px">#</th>
        <th>{{ trans("admin.CatName") }}</th>
        <th>{{ trans("admin.Slug") }}</th>
        <th>{{ trans("admin.Createdat") }}</th>
        <th style="width: 140px">{{ trans("admin.Actions") }}</th>
    </tr>
    @foreach(\App\Categories::byType($altcategories->id)->get() as  $i => $cat)
            <tr style="background-color: #fff;">
                <td>{{ ceil($i+1) }}.</td>
                <td>{{ $cat->name }}</td>
                <td>{{ $cat->name_slug }}</td>
                <td>{{ $cat->created_at }}</td>
                <td>
                    <a href="categories?edit={{ $cat->id }}" class="btn btn-sm btn-success" role="button" data-toggle="tooltip" title="" data-original-title="{{ trans("admin.edit") }}"><i class="fa fa-edit"></i></a>
                    <a class="btn btn-sm btn-danger permanently" href="{{ url('admin/categories/delete/'.$cat->id) }}" role="button" data-toggle="tooltip" data-original-title="{{ trans("admin.delete") }}"><i class="fa fa-times"></i></a>
                </td>
            </tr>
            @foreach(\App\Categories::where('type', $cat->id)->get() as  $io => $catq)
                <tr style="background-color: #f6f6f6;">
                    <td></td>
                    <td>{{ $catq->name }}</td>
                    <td>{{ $catq->name_slug }}</td>
                    <td>{{ $catq->created_at }}</td>
                    <td>
                        <a href="categories?edit={{ $catq->id }}" class="btn btn-sm btn-success" role="button" data-toggle="tooltip" title="" data-original-title="{{ trans("admin.edit") }}"><i class="fa fa-edit"></i></a>
                        <a class="btn btn-sm btn-danger permanently" href="{{ url('admin/categories/delete/'.$catq->id) }}" role="button" data-toggle="tooltip" data-original-title="{{ trans("admin.delete") }}"><i class="fa fa-times"></i></a>
                    </td>
                </tr>
            @endforeach

        @endforeach
    </tbody>
</table>
@endif