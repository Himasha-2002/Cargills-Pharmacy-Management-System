// script.js
document.querySelector('.cancel-btn').addEventListener('click', () => {
    alert('Cancelled');
  });
  
  document.querySelector('.save-btn').addEventListener('click', (e) => {
    e.preventDefault();
    alert('Saved successfully!');
  });
  