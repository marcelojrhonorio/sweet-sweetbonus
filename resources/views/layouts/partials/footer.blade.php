@if('home' === $page)
  <footer>
    © {{ now()->year }} Sweet | Todos os direitos reservados | <a href="{{ url('politica-de-privacidade-sweet') }}">Política de Privacidade</a>
  </footer>
@elseif('xmove-car' === $page)
  <footer>
    © {{ now()->year }} XMove Car | Todos os direitos reservados</a>
  </footer>
@else
  <footer>
    © {{ now()->year }} Sweet | <a class="footer-link" href="{{ url('termos-e-condicoes') }}">Termos e Condições</a> | <a class="footer-link" href="{{ url('politica-de-privacidade') }}">Política de Privacidade</a> | Todos os direitos reservados.
  </footer>
@endif
