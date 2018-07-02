if (window.addEventListener)  // W3C DOM
	window.addEventListener('load', init, false);
else if (window.attachEvent) { // IE DOM
	window.attachEvent('onload', init);
}else{ //NO SUPPORT, lauching right now
	init();
}

function init() {
	heightBoxUnder();
	heightImage();
	heightSeparator();
	resizeModal();
	modalDisplayOnOff();
	resizeVideo();


	$(window).resize(function(){
		heightImage();
		heightSeparator();
		heightBoxUnder();
		itemActionHeight();
		resizeModal();
		resizeVideo();
	});




	$(function () {
		return $('[data-toggle]').on('click', function () {
			var toggle;
			toggle = $(this).addClass('active').attr('data-toggle');
			$(this).siblings('[data-toggle]').removeClass('active');
			return $('.surveys').removeClass('grid list').addClass(toggle);
		});
	});
};

function modalDisplayOnOff(){
	var scrollPos = 0;
	$('.wp_voting_survey-profil-button').each(function(){
		$(this).click(function(){
			var idModal ='#' + $(this).attr('data-open');
			$(idModal).parent().css('visibility','visible').hide().fadeIn();
			var heightModal = $(idModal).height();
			$(idModal).find('.wp_voting_modal-item-inner').height(heightModal);
			scrollPos = $(window).scrollTop();
			$('body').css('top', -scrollPos+'px').addClass('html_no_scroll');

		});
	});



	$('.wp_voting_modal-close-button').each(function(){
		$(this).click(function(){
			var idModal = $(this).parent();
			
			$(idModal).parent().css('visibility','hidden').css('display','');
			$('body').attr('style', '').removeClass('html_no_scroll');
			$(window).scrollTop(scrollPos);

		});
	});

}


function resizeModal(){
	
	if($(window).width() >= 900 ){
		var maxHeightModal = 0;

		$(".wp_voting_pop-in").each(function(){
			if($(this).is(':visible')) {
				var heightModal = $(this).find('.wp_voting_modal').height();
				if (heightModal > maxHeightModal){
					maxHeightModal = heightModal;
				};
			} else {
				$(this).attr('style','display:block; visibility:hidden');
				var heightModal = $(this).find('.wp_voting_modal').height();
				if (heightModal > maxHeightModal){
					maxHeightModal = heightModal;
				};
				$(this).attr('style','');
			}
		});

		$(".wp_voting_modal").each(function(){
			$(this).find('.wp_voting_modal-item-inner').height(maxHeightModal)
		});
	} else {
		$(".wp_voting_modal-item-inner").each(function(){
			$(this).attr('style','');
		});
	}
}

function itemActionHeight(){
	if($(window).width() >= 900 ){
		$('.wp_voting_contest-id').each(function(){

			$(this).find('.wp_voting_survey-item').each(function(){
				var heights = 0;
				$(this).find('.wp_voting_survey-item-action').children('.wp_voting_item-action').each(function(){
					heights = heights + $(this).height();
				});

				$(this).find('.wp_voting_survey-item-action').height(heights);
			});
			
		});
	} else {
		$('.wp_voting_survey-item-action').each(function(){
			$(this).attr("style", "");
		});
	}
	heightBoxInfos();
}


// Contest Item same height
function heightBoxUnder(){
	if($(window).width() >= 900 ){
		$('.wp_voting_contest-id').each(function(){

		// Div class wp_voting_survey-box-under
		var arrHeight = [];
		var surveyDiv= $(this).find('.wp_voting_survey-box-under');
		surveyDiv.each(function(){
			arrHeight.push($(this).height());
			
		});
		var maxHeight = 0;
		for (var i in arrHeight) {
			if(arrHeight[i]>maxHeight) {
				maxHeight=arrHeight[i];
			}
		}
		surveyDiv.each(function(){
			if($(this).height() != maxHeight){
				$(this).height(maxHeight);
			}
		});

		
	});
	} else {
		$('.wp_voting_survey-box-under').each(function(){
			$(this).attr("style", "");
		});
	}
	itemSubtitleHeight();
}

function heightBoxInfos(){
	if($(window).width() >= 900 ){
		$('.wp_voting_contest-id').each(function(){
			var maxInfos = 0;
			$('.wp_voting_infos').each(function(){
				var heightName = $(this).find('.wp_voting_survey-name').outerHeight();
				var heightSubtitle = $(this).find('.wp_voting_survey-subtitle').outerHeight();
				var heightExtract = $(this).find('.wp_voting_survey-extract').outerHeight();
				var heightInfos = heightName + heightSubtitle + heightExtract;
				if (heightInfos > maxInfos){
					maxInfos = heightInfos;
				};
			});
			$('.wp_voting_infos').each(function(){
				$(this).height(maxInfos);
			});
			
		});
	} else {
		$('.wp_voting_infos').each(function(){
			$(this).attr("style", "");
		});
	}
	itemSubtitleHeight();
}

// function itemNameHeight(){
// 	$('.wp_voting_contest-id').each(function(){

// 		// Div class wp_voting_survey-name
// 		var arrHeightName = [];
// 		var surveyDivName = $(this).find('.wp_voting_survey-name');
// 		surveyDivName.each(function(){
// 			arrHeightName.push($(this).height());
// 		});
// 		var maxHeightName = 0;
// 		for (i in arrHeightName) {
// 			if(arrHeightName[i]>maxHeightName) {
// 				maxHeightName=arrHeightName[i];
// 			}
// 		}

// 		surveyDivName.each(function(){
// 			if($(this).height() != maxHeightName){
// 				$(this).height(maxHeightName);
// 			}
// 		});
// 	});
// }

function itemSubtitleHeight(){
	if($(window).width() >= 900 ){
		$('.wp_voting_contest-id').each(function(){
		// Div class wp_voting_survey-subtitle
		var arrHeightSub = [];
		var surveyDivSubtitle = $(this).find('.wp_voting_survey-subtitle');
		surveyDivSubtitle.each(function(){
			arrHeightSub.push($(this).height());

		});
		var maxHeightSub = 0;
		for (var i in arrHeightSub) {
			if(arrHeightSub[i]>maxHeightSub) {
				maxHeightSub=arrHeightSub[i];
			}
		}

		surveyDivSubtitle.each(function(){
			if($(this).height() != maxHeightSub){
				$(this).height(maxHeightSub);
			}
		});
	});
	} else {
		$('.wp_voting_survey-subtitle').each(function(){
			$(this).attr("style", "");
		});
	}
}



// function maxHeightSubtitle(){
// 	$('.wp_voting_contest-id').each(function(){
// 		var maxSubtitle = 0;
// 		$('.wp_voting_survey-subtitle').each(function(){
// 			var heightSubtitle = $(this).height();
// 			if (heightSubtitle > maxSubtitle){
// 				maxSubtitle = heightSubtitle;
// 			};
// 		});
// 		$('.wp_voting_survey-subtitle').each(function(){
// 			$(this).height(maxSubtitle);
// 		});
// 	});
// }

function heightImage(){
	$('.wp_voting_contest-id').each(function(){
		var widthImage = $(this).find('.wp_voting_survey-country').width();
		$(this).find('.wp_voting_survey-country').height(widthImage);
	});
}

function heightSeparator(){
	if($(window).width() >= 900 ){
		$('.wp_voting_contest-id').each(function(){
			var heightItem = $(this).find('.wp_voting_survey-item').outerHeight();
			$(this).find('.wp_voting_separator').height(heightItem).show();
		});
	} else {
		$('.wp_voting_separator').each(function(){
			$(this).hide();
		});
	}
}



function resizeVideo(){
	try {
		var yt_size = eval('wp_voting_item_yt');
	} catch (e) {
	}

	if (yt_size != 'undefined' ){
		yt_size = yt_size[0];
		var ratio = yt_size.width/yt_size.height;

		$('.wp_voting_pop-in').each(function(){

			if ($(this).find('.wp_voting_modal_video').length){
				if ($(window).width() <= 900){
					var iframeWidth = $(this).find(".wp_voting_modal-container-yt").width();
				} else {
					var iframeWidth = $(this).find(".wp_voting_modal-container-yt").width() * 90/100;
				};

				var iframeHeight = iframeWidth / ratio;
				$(this).find('.wp_voting_modal_video').width(iframeWidth);
				$(this).find('.wp_voting_modal_video').height(iframeHeight);
				
				if ($(window).width() <= 900){
					$(this).find('.wp_voting_modal-container-yt').height(iframeHeight);
				} else{
					$(this).find('.wp_voting_modal-container-yt').css('height','100%' );
				};
			}
		});
	}
}


