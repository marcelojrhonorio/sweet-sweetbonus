
@include('layouts.partials.main')

@if('home' !== $page)
  @include('layouts.partials.steps')
  @include('layouts.partials.faq')
  @include('layouts.partials.main-questions')
  @include('layouts.partials.products')
@endif

@include('layouts.partials.text-about')

@include('layouts.partials.footer')
