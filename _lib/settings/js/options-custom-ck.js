/**
 * Prints out the inline javascript needed for the colorpicker and choosing
 * the tabs in the panel.
 */jQuery(document).ready(function(e){function n(){e(this).attr("checked")?e(this).parent().parent().parent().nextAll().removeClass("hidden"):e(this).parent().parent().parent().nextAll().each(function(){if(e(this).filter(".last").length){e(this).addClass("hidden");return!1}e(this).addClass("hidden")})}e(".fade").delay(1e3).fadeOut(1e3);e(".colorSelector").each(function(){var t=this,n=e(t).next("input").attr("value");e(this).ColorPicker({color:n,onShow:function(t){e(t).fadeIn(500);return!1},onHide:function(t){e(t).fadeOut(500);return!1},onChange:function(n,r,i){e(t).children("div").css("backgroundColor","#"+r);e(t).next("input").attr("value","#"+r)}})});e(".group").hide();var t="";typeof localStorage!="undefined"&&(t=localStorage.getItem("activetab"));t!=""&&e(t).length?e(t).fadeIn():e(".group:first").fadeIn();e(".group .collapsed").each(function(){e(this).find("input:checked").parent().parent().parent().nextAll().each(function(){if(e(this).hasClass("last")){e(this).removeClass("hidden");return!1}e(this).filter(".hidden").removeClass("hidden")})});t!=""&&e(t+"-tab").length?e(t+"-tab").addClass("nav-tab-active"):e(".nav-tab-wrapper a:first").addClass("nav-tab-active");e(".nav-tab-wrapper a").click(function(t){e(".nav-tab-wrapper a").removeClass("nav-tab-active");e(this).addClass("nav-tab-active").blur();var n=e(this).attr("href");typeof localStorage!="undefined"&&localStorage.setItem("activetab",e(this).attr("href"));e(".group").hide();e(n).fadeIn();t.preventDefault();e(".wp-editor-wrap").each(function(){var t=e(this).find("iframe");t.height()<30&&t.css({height:"auto"})})});e(".group .collapsed input:checkbox").click(n);e(".of-radio-img-img").click(function(){e(this).parent().parent().find(".of-radio-img-img").removeClass("of-radio-img-selected");e(this).addClass("of-radio-img-selected")});e(".of-radio-img-label").hide();e(".of-radio-img-img").show();e(".of-radio-img-radio").hide()});