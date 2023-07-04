(function($) {
    'use strict';

    function displayLoading(button) {
        $(button).prop('disabled', true);
        $(button).children().css('display', 'inline-block');
    }

    function resetLoading(button) {
        $(button).prop('disabled', false);
        $(button).children('div').hide();
    }

    function WTBtnResponse(result_selector, html = "") {
        if (!result_selector) {
            result_selector = '.seo-crawl-status'
        }
        $(result_selector).html(html);
    }

    $('body').on('click', '#start-crawl', function(){
        sendAjaxRequest('do_crawl_process',
            '#start-crawl',
            '.seo-crawl-status',
        );
        showBtn('#stop-crawling');
    });

    $('body').on('click', '#stop-crawling', function(){
        sendAjaxRequest('stop_sync_crawling',
            '#stop-crawling',
            '',
        );

        showBtn('#start-crawl');
        hideBtn('#stop-crawling');
    });

    function sendAjaxRequest(action, button, result_selector, reload = true) {

        displayLoading(button);

        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: seocrawl.ajax_url,
            data: {
                action: action,
                security: seocrawl.nonce,
            },
            success: function(response) {
                WTBtnResponse(result_selector, response.data);
                resetLoading(button);
				if(reload){
					window.location.reload();
				}
            },
            error: function(e){
                resetLoading(button);
                console.log('crawl error==>', e);
            }
        });
    }

    function showBtn(selector) {
        $(selector).show();
    }

    function hideBtn(selector) {
        $(selector).hide();
    }

})(jQuery);
