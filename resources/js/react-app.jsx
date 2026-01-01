/**
 * React Application Entry Point
 * 
 * This file mounts React components into Blade-provided containers
 * as "islands" where interactivity is needed.
 */

import React from 'react';
import { createRoot } from 'react-dom/client';
import { mountComponents } from './utils/mountComponents';

/**
 * Mount all React components when DOM is ready
 */
document.addEventListener('DOMContentLoaded', () => {
  mountComponents();
  console.log('✅ React components mounted');
});

/**
 * Export utilities for use in other modules
 */
export { React, createRoot, mountComponents };
