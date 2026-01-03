// resources/js/utils/mountComponents.js
import LikeButton from '../components/LikeButton';
import Comments from '../components/Comments';

const componentMap = {
  LikeButton,
  Comments,
};

function parseProps(element) {
  const props = {};
  for (let attr of element.attributes) {
    if (attr.name.startsWith('data-')) {
      const propName = attr.name.substring(5); // Remove 'data-' prefix
      let value = attr.value;

      // Handle JSON props that need parsing
      if (propName === 'initialComments' || propName === 'user') {
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
      ReactDOM.render(<Component {...props} />, element);
    });
  });
}