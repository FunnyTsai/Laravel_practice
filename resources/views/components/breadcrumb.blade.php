<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item fs-4">
          <a href="{{ route($page . '.index') }}">
              {{ $pageName }}
          </a>        
        </li>
        <li class="breadcrumb-item active fs-4" aria-current="page">{{ $title }}</li>
    </ol>
</nav>
