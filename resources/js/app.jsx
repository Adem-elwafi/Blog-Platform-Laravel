import './bootstrap';
import { gsap } from 'gsap';
import Alpine from 'alpinejs';
import { mountComponents } from './utils/mountComponents';

window.Alpine = Alpine;
Alpine.start();

// Mount all React island components
document.addEventListener('DOMContentLoaded', () => {
    mountComponents();
    
    gsap.from('#title', {
        duration: 1,
        y: -50,
        opacity: 0,
        ease: 'power2.out',
    });
});