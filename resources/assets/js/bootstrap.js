// window._ = require('lodash');

/**
 * We'll load jQuery and the Bootstrap jQuery plugin which provides support
 * for JavaScript based Bootstrap features such as modals and tabs. This
 * code may be modified to fit the specific needs of your application.
 */

try {
    // window.$ = window.jQuery = require('jquery');
    require('bootstrap-sass');
} catch (e) {
}

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

// window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/**
 * Next we will register the CSRF Token as a common header with Axios so that
 * all outgoing HTTP requests automatically have it attached. This is just
 * a simple convenience so we don't have to attach every token manually.
 */

let token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}
window.axios.defaults.withCredentials = false;
window.axios.interceptors.request.use((config) => {
    config.validateStatus = (status) => {
        return status >= 200 && status <= 502;
    };
    if (config.method === 'post' || config.method === 'put') {
        window.loadingTimer = setTimeout(() => {
            window.app.loading({
                message: '提交中...',
            });
        }, 200);
    }
    return config;
}, error => {
    window.app.hideLoading();
    return Promise.reject(error);
});
window.axios.interceptors.response.use(res => {
    clearTimeout(window.loadingTimer);
    window.app.hideLoading();
    if (res.status < 200 || res.status >= 400) {
        if (res.config.method === 'get' && res.status === 404) {
            alert('资源不存在！');
        } else {
            $.notify('网络异常', {
                type: 'warning',
            });
        }
        return Promise.reject(res);
    };
    return res;
}, error => {
    window.app.hideLoading();
    return Promise.reject(error);
});

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

// import Echo from 'laravel-echo'

// window.Pusher = require('pusher-js');

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: 'your-pusher-key'
// });

// export default {
//     getRoot: () => {
//         let root = location.pathname;
//         if (root.substr(-1) === '/') {
//             return root;
//         } else {
//             return root + '/';
//         }
//     },
// };
