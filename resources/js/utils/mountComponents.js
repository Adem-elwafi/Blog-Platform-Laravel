// resources/js/utils/mountComponents.js
import React from 'react';
import { createRoot } from 'react-dom/client';
import LikeButton from '../components/LikeButton';
import Comments from '../components/Comments';
import PostFilters from '../components/PostFilters';

const componentMap = {
  LikeButton,
  Comments,
  PostFilters,
};

function parseProps(element) {
  const props = {};
  for (let attr of element.attributes) {
    if (attr.name.startsWith('data-')) {
      // Remove 'data-' prefix and convert to camelCase
      const propName = attr.name
        .substring(5)
        .replace(/-([a-z])/g, (match, letter) => letter.toUpperCase());
      
      let value = attr.value;

      // Handle JSON props that need parsing
      if (propName === 'initialComments' || propName === 'user' || propName === 'authors') {
        try {
          value = JSON.parse(value);
        } catch (e) {
          console.warn(`Failed to parse JSON prop: ${propName}`, e);
          value = null;
        }
      } else if (propName === 'postId') {
        // Convert postId to number
        value = parseInt(value, 10);
      }

      props[propName] = value;
    }
  }
  return props;
}

export function mountComponents() {
  Object.keys(componentMap).forEach(componentName => {
    const elements = document.querySelectorAll(`[data-component="${componentName}"]`);
    elements.forEach(element => {
      const props = parseProps(element);
      const Component = componentMap[componentName];
      const root = createRoot(element);
      root.render(React.createElement(Component, props));
    });
  });
}