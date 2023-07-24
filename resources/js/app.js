import './bootstrap';

import { createApp } from 'vue'
import App from './App.vue'

import { library } from '@fortawesome/fontawesome-svg-core';
import { faEye, faEyeSlash, faCaretDown, faUser, faTruck, faCreditCard, faClipboard, faSpinner, faTimes, faTimesCircle, faCircleCheck } from '@fortawesome/free-solid-svg-icons';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';

library.add(faEye, faEyeSlash, faCaretDown, faUser, faTruck, faCreditCard, faClipboard, faSpinner, faTimes, faTimesCircle, faCircleCheck);

createApp(App)
  .component('font-awesome-icon', FontAwesomeIcon)
  .mount("#app");
