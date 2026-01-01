/**
 * React Application Entry Point
 * 
 * This file is the main entry point for React components.
 * It prepares React for use but does NOT mount anything yet.
 * 
 * React components will be mounted into specific Blade views
 * as "islands" where interactivity is needed.
 */

import React from 'react';
import { createRoot } from 'react-dom/client';

/**
 * Export utilities for mounting React components from Blade views
 */
export { React, createRoot };

/**
 * Console confirmation that React is loaded and ready
 */
console.log('✅ React loaded and ready for component mounting');
