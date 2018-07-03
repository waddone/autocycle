<div class="col-xs-12 col-md-2 blockStanga">
    <ul class="blockStangaUl">
        <li><a href="{{ route('contul-meu') }}">Contul meu</a></li>
        <li><a href="{{ route('adauga-anunt') }}">Adauga anunt</a></li>
        <li><a href="{{ route('generator-anunturi') }}">Generator anunturi</a></li>
        <li><a href="{{ route('generator-anunturi-nou') }}">Generator anunturi nou</a></li>
        <li><a href="{{ route('anunturi') }}">Anunturi</a> <span class="countes">{{ Auth::user()->hasActiveAds() }}</span></li>
        <li><a href="{{ route('anunturi-sterse') }}">Anunturi sterse</a> <span class="countes">{{ Auth::user()->hasSterseAds() }}</span></li>
        <li><a href="{{ route('seturi-anunturi') }}">Seturi anunturi </a> <span class="countes">{{ Auth::user()->hasSeturiAds() }}</span></li>
        <li><a href="{{ route('cereri-active') }}">Cereri piese </a> <span class="countes">{{ Auth::user()->hasCereri() }}</span></li>
        <li><a href="{{ route('newsletter') }}">Newsletter </a></li>
        <li><a href="{{ route('newsletter-add') }}">Adauga user in newsletter </a></li>
        <li><a href="{{ route('newsletter-view') }}">Trimite newsletter</a></li>
    </ul>
</div>
   