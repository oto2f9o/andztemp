<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family={{ str_replace(' ', '+', config('app.settings.font_family.head', 'Poppins')) }}:wght@400;600;700&display=swap" rel="preload" as="style" onload="this.onload=null;this.rel='stylesheet'">
<link href="https://fonts.googleapis.com/css2?family={{ str_replace(' ', '+', config('app.settings.font_family.body', 'Poppins')) }}:wght@400;600&display=swap" rel="preload" as="style" onload="this.onload=null;this.rel='stylesheet'">
<style>
:root {
  --head-font: "{{ config('app.settings.font_family.head', 'Poppins') }}";
  --body-font: "{{ config('app.settings.font_family.body', 'Poppins') }}";
  --primary: {{ config('app.settings.colors.primary', '#0155b5') }};
  --secondary: {{ config('app.settings.colors.secondary', '#2fc10a') }};
  --tertiary: {{ config('app.settings.colors.tertiary', '#d2ab3e') }};
}
</style>
<script>
  let captcha_name = "{{ config('app.settings.captcha', 'off') }}";
  let site_key = "";
  if(captcha_name && captcha_name !== "off") {
    site_key = "{{ config('app.settings.' . config('app.settings.captcha') . '.site_key', '') }}";
  }
  let strings = {!! json_encode(\Lang::get('*')); !!}
  const __ = (string) => {
    if(strings[string] !== undefined) {
      return strings[string];
    } else {
      return string;
    }
  }
</script>
@foreach(['success', 'error'] as $type)
@if(Session::has($type))
<script defer>
  document.addEventListener("DOMContentLoaded", () => {
    document.dispatchEvent(new CustomEvent("showAlert", {
      bubbles: true,
      detail: {
        type: "{{ $type }}",
        message: "{{ Session::get($type) }}",
      },
    }));
  });
</script>
@endif
@endforeach