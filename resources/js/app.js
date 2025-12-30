import './bootstrap';
import { gsap } from "gsap";
import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();


// Example animation on page load
document.addEventListener("DOMContentLoaded", () => {
    gsap.from("#title", {
        duration: 1,
        y: -50,
        opacity: 0,
        ease: "power2.out"
    });
});
