import { createRoot } from 'react-dom/client';

/**
 * Mount a React component into a Blade-provided DOM node
 * 
 * Usage in Blade:
 * <div 
 *   id="react-like-button-123"
 *   data-component="LikeButton"
 *   data-post-id="123"
 *   data-initial-liked="true"
 *   data-initial-likes-count="42"
 * ></div>
 */
export function mountComponents() {
  // Find all elements that should have React components
  const elements = document.querySelectorAll('[data-component]');

  elements.forEach((element) => {
    const componentName = element.dataset.component;
    
    // Dynamically import the component
    import(`../components/${componentName}.jsx`).then((module) => {
      const Component = module.default;

      // Extract all data-* attributes and convert to props
      const props = Object.entries(element.dataset).reduce((acc, [key, value]) => {
        if (key === 'component') return acc; // Skip component name itself

        // Convert camelCase data attributes to proper types
        if (value === 'true') return { ...acc, [key]: true };
        if (value === 'false') return { ...acc, [key]: false };
        if (!isNaN(value)) return { ...acc, [key]: Number(value) };
        return { ...acc, [key]: value };
      }, {});

      // Mount the component using React's createRoot
      const root = createRoot(element);
      const React = require('react');
      root.render(React.createElement(Component, props));
    }).catch((error) => {
      console.error(`Failed to load component ${componentName}:`, error);
    });
  });
}
