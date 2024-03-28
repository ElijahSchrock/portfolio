import './bootstrap';

import { Livewire } from '../../vendor/livewire/livewire/dist/livewire.esm';
import { Notyf } from 'notyf';
import 'notyf/notyf.min.css'; // for React, Vue and Svelte

window.notyf = new Notyf();

Livewire.start()
