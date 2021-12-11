@if (session('flash_message'))
  <p class="alert alert-success" role="alert">{{ session('flash_message') }}</p>
@endif