import './bootstrap';
import { gsap } from 'gsap';
import Alpine from 'alpinejs';
import './react-app.jsx'; // React mount logic is bundled via the single entry

window.Alpine = Alpine;
Alpine.start();

document.addEventListener('DOMContentLoaded', () => {
    gsap.from('#title', {
        duration: 1,
        y: -50,
        opacity: 0,
        ease: 'power2.out',
    });
});