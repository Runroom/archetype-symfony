import jsCookies from 'js-cookie';

function Cookies() {
    let opts = {
        element: '.js-cookies',
        button: '.js-cookiesAccept',
        cookie: 'accept_cookies',
        visible: 'is-visible'
    };

    function bindUIAction() {
        let accepted = jsCookies.get(opts.cookie);

        if(accepted === undefined) {
            $(opts.element).addClass(opts.visible);
        }
        $(opts.button).on('click', function(event) {
            event.preventDefault();
            jsCookies.set(opts.cookie, 'true', { expires: 365 });
            $(opts.element).removeClass(opts.visible);
        });
    }

    return {
        init: bindUIAction
    }
}

export default Cookies();
