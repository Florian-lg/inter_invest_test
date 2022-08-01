/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.scss';

// start the Stimulus application
import './bootstrap';
import * as tempusDominus from "@eonasdan/tempus-dominus";

const $ = require('jquery');
require('bootstrap');

const picker = new tempusDominus.TempusDominus(document.getElementById('inlinePicker'), {
    display: {
        inline: true
    }
});



$(".day").on("click", function () {
    const viewDate = picker.viewDate;

    let date = {
        'year': viewDate.getFullYear(),
        'month': (viewDate.getMonth() + 1) < 10 ? `0${(viewDate.getMonth() + 1)}` : (viewDate.getMonth() + 1),
        'day': viewDate.getDate() < 10 ? `0${viewDate.getDate()}` : viewDate.getDate(),
        'hours': viewDate.getHours() < 10 ? `0${viewDate.getHours()}` : viewDate.getHours(),
        'minutes': viewDate.getMinutes() < 10 ? `0${viewDate.getMinutes()}` : viewDate.getMinutes(),
        'seconds': viewDate.getSeconds() < 10 ? `0${viewDate.getSeconds()}` : viewDate.getSeconds()
    };

    var url = window.location.href;
    const paramsIndex = url.indexOf("?date");
    console.log(paramsIndex)

    if (paramsIndex > -1) {
        url = url.slice(0, paramsIndex);
    }

    url += `?date=${date.year}-${date.month}-${date.day}-${date.hours}-${date.minutes}-${date.seconds}`;

    window.location.href = url;
})

