import $ from 'jquery';
import 'jquery-validation';

window.$ = window.jQuery = $;

import './bootstrap';
import './dropzone.js'
import './formEntrySubmit.js'
import './layoutNavigation.js'

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();
