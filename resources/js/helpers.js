// resources/js/helpers.js

export const route = (name, params = {}) => {
    // This is just an example, you might want to integrate a full URL generation library here.
    // Laravel's helper function `route` cannot be directly used in the front-end.
    return `/api/${name}`;  // Replace with actual route logic or API endpoint path
  };
  