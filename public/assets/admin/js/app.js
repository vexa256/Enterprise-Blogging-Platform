if ("undefined" == typeof jQuery) throw new Error("AdminLTE requires jQuery");

function _init() {
    "use strict";
    $.AdminLTE.layout = {
        activate: function() {
            var e = this;
            e.fix(), e.fixSidebar(), $(window, ".wrapper").resize(function() {
                e.fix(), e.fixSidebar()
            })
        },
        fix: function() {
            var e = $(".main-header").outerHeight() + $(".main-footer").outerHeight(),
                t = $(window).height(),
                i = $(".sidebar").height();
            if ($("body").hasClass("fixed")) $(".content-wrapper, .right-side").css("min-height", t - $(".main-footer").outerHeight());
            else {
                var o;
                t >= i ? ($(".content-wrapper, .right-side").css("min-height", t - e), o = t - e) : ($(".content-wrapper, .right-side").css("min-height", i), o = i);
                var n = $($.AdminLTE.options.controlSidebarOptions.selector);
                void 0 !== n && n.height() > o && $(".content-wrapper, .right-side").css("min-height", n.height())
            }
        },
        fixSidebar: function() {
            $("body").hasClass("fixed") ? (void 0 === $.fn.slimScroll && window.console && window.console.error("Error: the fixed layout requires the slimscroll plugin!"), $.AdminLTE.options.sidebarSlimScroll && void 0 !== $.fn.slimScroll && ($(".sidebar").slimScroll({
                destroy: !0
            }).height("auto"), $(".sidebar").slimscroll({
                height: $(window).height() - $(".main-header").height() + "px",
                color: "rgba(0,0,0,0.2)",
                size: "3px"
            }))) : void 0 !== $.fn.slimScroll && $(".sidebar").slimScroll({
                destroy: !0
            }).height("auto")
        }
    }, $.AdminLTE.pushMenu = {
        activate: function(e) {
            var t = $.AdminLTE.options.screenSizes;
            $(e).on("click", function(e) {
                e.preventDefault(), $(window).width() > t.sm - 1 ? $("body").hasClass("sidebar-collapse") ? $("body").removeClass("sidebar-collapse").trigger("expanded.pushMenu") : $("body").addClass("sidebar-collapse").trigger("collapsed.pushMenu") : $("body").hasClass("sidebar-open") ? $("body").removeClass("sidebar-open").removeClass("sidebar-collapse").trigger("collapsed.pushMenu") : $("body").addClass("sidebar-open").trigger("expanded.pushMenu")
            }), $(".content-wrapper").click(function() {
                $(window).width() <= t.sm - 1 && $("body").hasClass("sidebar-open") && $("body").removeClass("sidebar-open")
            }), ($.AdminLTE.options.sidebarExpandOnHover || $("body").hasClass("fixed") && $("body").hasClass("sidebar-mini")) && this.expandOnHover()
        },
        expandOnHover: function() {
            var e = this,
                t = $.AdminLTE.options.screenSizes.sm - 1;
            $(".main-sidebar").hover(function() {
                $("body").hasClass("sidebar-mini") && $("body").hasClass("sidebar-collapse") && $(window).width() > t && e.expand()
            }, function() {
                $("body").hasClass("sidebar-mini") && $("body").hasClass("sidebar-expanded-on-hover") && $(window).width() > t && e.collapse()
            })
        },
        expand: function() {
            $("body").removeClass("sidebar-collapse").addClass("sidebar-expanded-on-hover")
        },
        collapse: function() {
            $("body").hasClass("sidebar-expanded-on-hover") && $("body").removeClass("sidebar-expanded-on-hover").addClass("sidebar-collapse")
        }
    }, $.AdminLTE.tree = function(e) {
        var t = this,
            i = $.AdminLTE.options.animationSpeed;
        $(document).on("click", e + " li a", function(e) {
            var o = $(this),
                n = o.next();
            if (n.is(".treeview-menu") && n.is(":visible")) n.slideUp(i, function() {
                n.removeClass("menu-open")
            }), n.parent("li").removeClass("active");
            else if (n.is(".treeview-menu") && !n.is(":visible")) {
                var a = o.parents("ul").first();
                a.find("ul:visible").slideUp(i).removeClass("menu-open");
                var s = o.parent("li");
                n.slideDown(i, function() {
                    n.addClass("menu-open"), a.find("li.active").removeClass("active"), s.addClass("active"), t.layout.fix()
                })
            }
            n.is(".treeview-menu") && e.preventDefault()
        })
    }, $.AdminLTE.controlSidebar = {
        activate: function() {
            var e = this,
                t = $.AdminLTE.options.controlSidebarOptions,
                i = $(t.selector);
            $(t.toggleBtnSelector).on("click", function(o) {
                o.preventDefault(), i.hasClass("control-sidebar-open") || $("body").hasClass("control-sidebar-open") ? e.close(i, t.slide) : e.open(i, t.slide)
            });
            var o = $(".control-sidebar-bg");
            e._fix(o), $("body").hasClass("fixed") ? e._fixForFixed(i) : $(".content-wrapper, .right-side").height() < i.height() && e._fixForContent(i)
        },
        open: function(e, t) {
            t ? e.addClass("control-sidebar-open") : $("body").addClass("control-sidebar-open")
        },
        close: function(e, t) {
            t ? e.removeClass("control-sidebar-open") : $("body").removeClass("control-sidebar-open")
        },
        _fix: function(e) {
            var t = this;
            $("body").hasClass("layout-boxed") ? (e.css("position", "absolute"), e.height($(".wrapper").height()), $(window).resize(function() {
                t._fix(e)
            })) : e.css({
                position: "fixed",
                height: "auto"
            })
        },
        _fixForFixed: function(e) {
            e.css({
                position: "fixed",
                "max-height": "100%",
                overflow: "auto",
                "padding-bottom": "50px"
            })
        },
        _fixForContent: function(e) {
            $(".content-wrapper, .right-side").css("min-height", e.height())
        }
    }, $.AdminLTE.boxWidget = {
        selectors: $.AdminLTE.options.boxWidgetOptions.boxWidgetSelectors,
        icons: $.AdminLTE.options.boxWidgetOptions.boxWidgetIcons,
        animationSpeed: $.AdminLTE.options.animationSpeed,
        activate: function(e) {
            var t = this;
            e || (e = document), $(e).on("click", t.selectors.collapse, function(e) {
                e.preventDefault(), t.collapse($(this))
            }), $(e).on("click", t.selectors.remove, function(e) {
                e.preventDefault(), t.remove($(this))
            })
        },
        collapse: function(e) {
            var t = e.parents(".box").first(),
                i = t.find("> .box-body, > .box-footer, > form  >.box-body, > form > .box-footer");
            t.hasClass("collapsed-box") ? (e.children(":first").removeClass(this.icons.open).addClass(this.icons.collapse), i.slideDown(this.animationSpeed, function() {
                t.removeClass("collapsed-box")
            })) : (e.children(":first").removeClass(this.icons.collapse).addClass(this.icons.open), i.slideUp(this.animationSpeed, function() {
                t.addClass("collapsed-box")
            }))
        },
        remove: function(e) {
            e.parents(".box").first().slideUp(this.animationSpeed)
        }
    }
}
$.AdminLTE = {}, $.AdminLTE.options = {
        navbarMenuSlimscroll: !0,
        navbarMenuSlimscrollWidth: "3px",
        navbarMenuHeight: "200px",
        animationSpeed: 200,
        sidebarToggleSelector: "[data-toggle='offcanvas']",
        sidebarPushMenu: !0,
        sidebarSlimScroll: !0,
        sidebarExpandOnHover: !1,
        enableBoxRefresh: !0,
        enableBSToppltip: !0,
        BSTooltipSelector: "[data-toggle='tooltip']",
        enableFastclick: !0,
        enableControlSidebar: !0,
        controlSidebarOptions: {
            toggleBtnSelector: "[data-toggle='control-sidebar']",
            selector: ".control-sidebar",
            slide: !0
        },
        enableBoxWidget: !0,
        boxWidgetOptions: {
            boxWidgetIcons: {
                collapse: "fa-minus",
                open: "fa-plus",
                remove: "fa-times"
            },
            boxWidgetSelectors: {
                remove: '[data-widget="remove"]',
                collapse: '[data-widget="collapse"]'
            }
        },
        directChat: {
            enable: !0,
            contactToggleSelector: '[data-widget="chat-pane-toggle"]'
        },
        colors: {
            lightBlue: "#3c8dbc",
            red: "#f56954",
            green: "#00a65a",
            aqua: "#00c0ef",
            yellow: "#f39c12",
            blue: "#0073b7",
            navy: "#001F3F",
            teal: "#39CCCC",
            olive: "#3D9970",
            lime: "#01FF70",
            orange: "#FF851B",
            fuchsia: "#F012BE",
            purple: "#8E24AA",
            maroon: "#D81B60",
            black: "#222222",
            gray: "#d2d6de"
        },
        screenSizes: {
            xs: 480,
            sm: 768,
            md: 992,
            lg: 1200
        }
    }, $(function() {
        "use strict";
        $("body").removeClass("hold-transition"), "undefined" != typeof AdminLTEOptions && $.extend(!0, $.AdminLTE.options, AdminLTEOptions);
        var e = $.AdminLTE.options;
        _init(), $.AdminLTE.layout.activate(), $.AdminLTE.tree(".sidebar"), e.enableControlSidebar && $.AdminLTE.controlSidebar.activate(), e.navbarMenuSlimscroll && void 0 !== $.fn.slimscroll && $(".navbar .menu").slimscroll({
            height: e.navbarMenuHeight,
            alwaysVisible: !1,
            size: e.navbarMenuSlimscrollWidth
        }).css("width", "100%"), e.sidebarPushMenu && $.AdminLTE.pushMenu.activate(e.sidebarToggleSelector), e.enableBSToppltip && $("body").tooltip({
            selector: e.BSTooltipSelector
        }), e.enableBoxWidget && $.AdminLTE.boxWidget.activate(), e.enableFastclick && "undefined" != typeof FastClick && FastClick.attach(document.body), e.directChat.enable && $(document).on("click", e.directChat.contactToggleSelector, function() {
            $(this).parents(".direct-chat").first().toggleClass("direct-chat-contacts-open")
        }), $('.btn-group[data-toggle="btn-toggle"]').each(function() {
            var e = $(this);
            $(this).find(".btn").on("click", function(t) {
                e.find(".btn.active").removeClass("active"), $(this).addClass("active"), t.preventDefault()
            })
        })
    }),
    function(e) {
        "use strict";
        e.fn.boxRefresh = function(t) {
            var i = e.extend({
                    trigger: ".refresh-btn",
                    source: "",
                    onLoadStart: function(e) {
                        return e
                    },
                    onLoadDone: function(e) {
                        return e
                    }
                }, t),
                o = e('<div class="overlay"><div class="fa fa-refresh fa-spin"></div></div>');
            return this.each(function() {
                if ("" !== i.source) {
                    var t = e(this);
                    t.find(i.trigger).first().on("click", function(e) {
                        e.preventDefault(),
                            function(e) {
                                e.append(o), i.onLoadStart.call(e)
                            }(t), t.find(".box-body").load(i.source, function() {
                                ! function(e) {
                                    e.find(o).remove(), i.onLoadDone.call(e)
                                }(t)
                            })
                    })
                } else window.console && window.console.log("Please specify a source first - boxRefresh()")
            })
        }
    }(jQuery),
    function(e) {
        "use strict";
        e.fn.activateBox = function() {
            e.AdminLTE.boxWidget.activate(this)
        }
    }(jQuery),
    function(e) {
        "use strict";
        e.fn.todolist = function(t) {
            var i = e.extend({
                onCheck: function(e) {
                    return e
                },
                onUncheck: function(e) {
                    return e
                }
            }, t);
            return this.each(function() {
                void 0 !== e.fn.iCheck ? (e("input", this).on("ifChecked", function() {
                    var t = e(this).parents("li").first();
                    t.toggleClass("done"), i.onCheck.call(t)
                }), e("input", this).on("ifUnchecked", function() {
                    var t = e(this).parents("li").first();
                    t.toggleClass("done"), i.onUncheck.call(t)
                })) : e("input", this).on("change", function() {
                    var t = e(this).parents("li").first();
                    t.toggleClass("done"), e("input", t).is(":checked") ? i.onCheck.call(t) : i.onUncheck.call(t)
                })
            })
        }
    }(jQuery),
(jQuery, window, document);