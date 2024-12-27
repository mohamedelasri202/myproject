
function toggleModal() {
  const modal = document.getElementById('activityModal');
  modal.classList.toggle('flex');
  modal.classList.toggle('hidden');
}

function editActivity(id, name, description, type, location, price, status) {
  document.getElementById('edit_id').value = id;
  document.getElementById('edit_name').value = name;
  document.getElementById('edit_description').value = description;
  document.getElementById('edit_type').value = type;
  document.getElementById('edit_location').value = location;
  document.getElementById('edit_price').value = price;
  document.getElementById('edit_status').value = status;
  
  const modal = document.getElementById('editModal');
  modal.classList.remove('hidden');
  modal.classList.add('flex');
}

function closeEditModal() {
  const modal = document.getElementById('editModal');
  modal.classList.remove('flex');
  modal.classList.add('hidden');
}