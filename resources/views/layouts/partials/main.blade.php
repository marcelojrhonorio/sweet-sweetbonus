@if('home' === $page)
    @include('layouts.partials.main-home')

@elseif('maquiagem' === $page)
    @include('layouts.partials.main-maquiagem')

@elseif('bebes' === $page)
    @include('layouts.partials.main-bebes')

@elseif('musculacao' === $page)
    @include('layouts.partials.main-musculacao')

@elseif('perfumes' === $page)
    @include('layouts.partials.main-perfumes')

@elseif('produtos' === $page)
    @include('layouts.partials.main-produtos')

@elseif('emagrecimento' === $page)
    @include('layouts.partials.main-emagrecimento')   

@elseif('dinheiro-na-internet' === $page)
    @include('layouts.partials.main-dinheiro-na-internet')    

@elseif('revenda' === $page)
    @include('layouts.partials.main-revenda')

@elseif('compartilhar' === $page)                 
    @include('layouts.partials.main-compartilhar')

@elseif('xmove-car' === $page)                 
    @include('layouts.partials.xmove-car')    
    
@endif