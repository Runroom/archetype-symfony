
import { Controller } from 'stimulus';

export default class extends Controller {
  connect() {
    this.element.textContent = 'Hello! Edit me in assets/js/controllers/hello_controller.js';
  }
}
