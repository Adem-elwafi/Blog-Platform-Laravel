import React, { useState, useEffect } from 'react';

export default function PostFilters({ authors = [], initialSearch = '', initialAuthor = '', initialSort = 'newest' }) {
  const [search, setSearch] = useState(initialSearch);
  const [author, setAuthor] = useState(initialAuthor);
  const [sort, setSort] = useState(initialSort);

  // Debounce search input and apply filters after 500ms of no typing
  // This prevents excessive page reloads while user is actively typing
  useEffect(() => {
    const timer = setTimeout(() => {
      applyFilters(search, author, sort);
    }, 500);

    // Clear timer if component unmounts or search changes again
    return () => clearTimeout(timer);
  }, [search]);

  // Apply filters immediately when author dropdown changes
  const handleAuthorChange = (e) => {
    const newAuthor = e.target.value;
    setAuthor(newAuthor);
    applyFilters(search, newAuthor, sort);
  };

  // Apply filters immediately when sort dropdown changes
  const handleSortChange = (e) => {
    const newSort = e.target.value;
    setSort(newSort);
    applyFilters(search, author, newSort);
  };

  // Build URL with search parameters and navigate to new filtered view
  // Uses URLSearchParams to properly encode parameters
  // Only includes non-empty filters in URL to keep it clean
  const applyFilters = (searchTerm, authorId, sortBy) => {
    const params = new URLSearchParams();
    
    if (searchTerm) params.append('search', searchTerm);
    if (authorId) params.append('author', authorId);
    if (sortBy && sortBy !== 'newest') params.append('sort', sortBy); // Only add sort if not default

    const newUrl = params.toString() 
      ? `/posts?${params.toString()}` 
      : '/posts';
    
    // Navigate to new URL (causes page reload with filtered results)
    window.location.href = newUrl;
  };

  // Check if any filters are active (other than default sort)
  const hasActiveFilters = search || author || (sort && sort !== 'newest');

  // Clear all filters and return to /posts
  const clearFilters = () => {
    window.location.href = '/posts';
  };

  return (
    <div className="bg-white dark:bg-gray-800 rounded-lg p-6 mb-8 border border-gray-200 dark:border-gray-700">
      <div className="grid grid-cols-1 md:grid-cols-3 gap-4">
        {/* Search Input - Debounced for better performance */}
        <div>
          <label htmlFor="search" className="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
            Search Posts
          </label>
          <input
            id="search"
            type="text"
            placeholder="Search by title or content..."
            value={search}
            onChange={(e) => setSearch(e.target.value)}
            className="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:text-white transition-colors duration-200"
          />
        </div>

        {/* Author Filter Dropdown - Immediate action */}
        <div>
          <label htmlFor="author" className="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
            Filter by Author
          </label>
          <select
            id="author"
            value={author}
            onChange={handleAuthorChange}
            className="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:text-white transition-colors duration-200"
          >
            <option value="">All Authors</option>
            {authors.map((auth) => (
              <option key={auth.id} value={auth.id}>
                {auth.name}
              </option>
            ))}
          </select>
        </div>

        {/* Sort Options Dropdown - Immediate action */}
        <div>
          <label htmlFor="sort" className="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
            Sort By
          </label>
          <select
            id="sort"
            value={sort}
            onChange={handleSortChange}
            className="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:text-white transition-colors duration-200"
          >
            <option value="newest">Newest First</option>
            <option value="popular">Most Popular (Likes)</option>
            <option value="commented">Most Commented</option>
          </select>
        </div>
      </div>

      {/* Clear Filters Button - Only displayed when filters are active */}
      {hasActiveFilters && (
        <div className="mt-4">
          <button
            onClick={clearFilters}
            className="px-4 py-2 bg-gray-300 dark:bg-gray-600 text-gray-800 dark:text-gray-200 rounded-lg hover:bg-gray-400 dark:hover:bg-gray-500 transition-colors duration-200 font-medium"
          >
            Clear Filters
          </button>
        </div>
      )}
    </div>
  );
}
