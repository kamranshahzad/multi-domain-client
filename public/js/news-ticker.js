(function(e){e.fn.rotateTestimonials=function(t){var n={delay:2e3,fadeSpeed:500};if(t){e.extend(n,t)}return this.each(function(){var t=e(this);var r=t.children("li");var i=r.length;var s=0;r.eq(0).show();setInterval(function(){r.eq(s).hide();s=s+1==i?0:s+1;r.eq(s).fadeIn(n.fadeSpeed)},n.delay);return this})};e.fn.slideTestimonials=function(t){var n={delay:2e3,fadeSpeed:500};if(t){e.extend(n,t)}return this.each(function(){var t=e(this);var r=t.children("li");var i=r.length;var s=0;r.eq(0).show();setInterval(function(){r.eq(s).hide("slide",{direction:"down"},200);s=s+1==i?0:s+1;r.eq(s).show("slide",{direction:"up"},1e3)},n.delay);return this})};e.fn.limita=function(t){var n={limit:200,id_result:false,alertClass:false};var t=e.extend(n,t);return this.each(function(){var n=t.limit;if(t.id_result!=false){e("#"+t.id_result).append("Ti restano <strong>"+n+"</strong> caratteri")}e(this).keyup(function(){if(e(this).val().length>n){e(this).val(e(this).val().substr(0,n))}if(t.id_result!=false){var r=n-e(this).val().length;e("#"+t.id_result).html("Ti restano <strong>"+r+"</strong> caratteri");if(r<=10){e("#"+t.id_result).addClass(t.alertClass)}else{e("#"+t.id_result).removeClass(t.alertClass)}}})})}})(jQuery)