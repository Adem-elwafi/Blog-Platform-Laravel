import { createElement } from 'react';
import { createRoot } from 'react-dom/client';

// ✅ STATIC imports (this is the key)
import LikeButton from '../components/LikeButton.jsx';

const components = {
  LikeButton,
};

// Store roots to prevent duplicate creation
const roots = new Map();

export function mountComponents() {
  document.querySelectorAll('[data-component]').forEach((el) => {
    // Skip if already mounted
    if (roots.has(el)) {
      return;
    }

    const name = el.dataset.component;
    const Component = components[name];

    if (!Component) {
      console.warn(`React component "${name}" not found`);
      return;
    }

    const props = {};
    for (const [key, value] of Object.entries(el.dataset)) {
      if (key === 'component') continue;

      props[key] =
        value === 'true'
          ? true
          : value === 'false'
          ? false
          : isNaN(value)
          ? value
          : Number(value);
    }

    const root = createRoot(el);
    root.render(createElement(Component, props));
    roots.set(el, root);
  });
}
