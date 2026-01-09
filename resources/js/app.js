import './bootstrap';
import Alpine from 'alpinejs';
import persist from '@alpinejs/persist';

// Initialize Alpine.js
Alpine.plugin(persist);

// Make Alpine available globally for debugging
window.Alpine = Alpine;

// Start Alpine
Alpine.start();
