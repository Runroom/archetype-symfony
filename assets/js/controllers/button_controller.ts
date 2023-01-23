import { Controller } from '@hotwired/stimulus';

/* stimulusFetch: 'lazy' */
export default class extends Controller {
  connect() {
    console.log('Hello Stimulus! Edit me in assets/controllers/hello_controller.js');
  }
}
