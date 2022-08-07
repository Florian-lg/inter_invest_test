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
import {DateTime} from "@eonasdan/tempus-dominus";

const $ = require('jquery');
require('bootstrap');

const pickerElement = document.getElementById('inlinePicker');

const picker = new tempusDominus.TempusDominus(pickerElement, {
    display: {
        inline: true
    },
    defaultDate: setDate()
});

$(document).ready( function () {
    setDate();

    $("#validate-date").on("click", function () {
        changeDate();
    });
});

function setDate() {
    var url = window.location.href;
    const paramsIndex = url.indexOf("?date");
    let selectedDate = new DateTime();

    if (paramsIndex > -1) {
        const params = url.slice(paramsIndex + 6);
        const values = params.split('-');

        let date = {
            'year': parseInt(values[0]),
            'month': parseInt(values[1]) - 1,
            'day': parseInt(values[2]),
            'hours': parseInt(values[3]),
            'minutes': parseInt(values[4]),
            'seconds': parseInt(values[5])
        };

        selectedDate.setFullYear(date.year);
        selectedDate.setMonth(date.month);
        selectedDate.setDate(date.day);
        selectedDate.setHours(date.hours);
        selectedDate.setMinutes(date.minutes);
        selectedDate.setSeconds(date.seconds);
    }

    return selectedDate;
}

function changeDate() {
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

    if (paramsIndex > -1) {
        url = url.slice(0, paramsIndex);
    }

    url += `?date=${date.year}-${date.month}-${date.day}-${date.hours}-${date.minutes}-${date.seconds}`;

    window.location.href = url;
}

