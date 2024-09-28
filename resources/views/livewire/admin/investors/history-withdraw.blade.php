    <!-- Responsive Datatable -->
        @php
        function formatNumber($number, $decimals = 6)
        {
            $formattedNumber = number_format($number, $decimals);
            return rtrim(rtrim($formattedNumber, '0'), '.');
        }
    @endphp
  
