/**
 * @namespace Grid 
 * @name GridLayout
 */

import React from 'react';

/**
 * Grid layout for floating objects
 * @name GridLayout
 * @memberOf GridLayout
 * @param {Nodes[]} options.children React nodes
 * @param {String} options.className Grid class name : grid, grid-flex
 */
export default function GridLayout({children, className}) {
  return (
    <div className = { className }>
      { children }
    </div>
  )
}

/**
 * Grid items
 * @name  GridItem
 * @memberOf GridLayout
 * @param {[type]} options.className Default class]
 * @param {[type]} options.grid      Grid options
 * @param {[type]} options.children  Child nodes
 */
export function GridItem({className, grid, children}) {
  
  // Apply class
  className = applyGrid(className, grid);

  return (
    <div className = { className }>
      { children }
    </div>
  )
}

GridItem.defaultProps = {
  className: 'grid__item',
  grid: {
    push: null,
    pull: null,
    col: null,
  }
}

GridLayout.defaultProps = {
  className: 'grid',
}

/**
 * Transform grid obj to style
 * @function applyGrid
 * @memberOf GridLayout
 * @param  {string} className Default class
 * @param  {object} grid      Grid object
 * @return {string}           Default class and grid class(es)
 */
function applyGrid(className, grid) {
  const GRID_TYPES = ['col', 'push', 'pull'];

  let updatedClass = className;

  for (let i = GRID_TYPES.length - 1; i >= 0; i--) {
    let type = GRID_TYPES[i];
    if (grid[type]) {
      for (let key in grid[type]) {
        updatedClass += ` ${type}-${key}-${grid[type][key]}`
      }
    }
  }

  return updatedClass;
}