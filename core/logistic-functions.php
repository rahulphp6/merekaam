<?php
function loader($name = 'infinity')
{
    switch ($name) {
        // Infinity Loop (SVG Path Trace)
        case 'infinity':
            echo '<div class="stage bg-dark vh-100 text-center d-flex align-items-center justify-content-center">
        <svg class="infinity-svg" width="160" height="70" viewBox="-5 5 170 60">
          <defs>
            <linearGradient id="infGrad" x1="0%" y1="0%" x2="100%" y2="0%">
              <stop offset="0%" stop-color="#ff3c6f" />
              <stop offset="50%" stop-color="#7c3aed" />
              <stop offset="100%" stop-color="#00d9ff" />
            </linearGradient>
          </defs>
          <path class="infinity-path"
            d="M80,35 C80,15 105,15 120,35 C135,55 160,55 160,35 C160,15 135,15 120,35 C105,55 80,55 80,35 C80,15 55,15 40,35 C25,55 0,55 0,35 C55,55 80,55 80,35 Z" />
        </svg>
      </div>';
            break;

        // CSS Loaders (01 to 42)
        case 'loader-01':
            echo '<div class="loader-01"></div>';
            break;
        case 'loader-02':
            echo '<div class="loader-02"></div>';
            break;
        case 'loader-03':
            echo '<div class="loader-03"></div>';
            break;
        case 'loader-04':
            echo '<div class="loader-04"></div>';
            break;
        case 'loader-05':
            echo '<div class="loader-05"></div>';
            break;
        case 'loader-06':
            echo '<div class="loader-06"></div>';
            break;
        case 'loader-07':
            echo '<div class="loader-07"></div>';
            break;
        case 'loader-08':
            echo '<div class="loader-08"></div>';
            break;
        case 'loader-09':
            echo '<div class="loader-09"></div>';
            break;
        case 'loader-10':
            echo '<div class="loader-10"></div>';
            break;
        case 'loader-11':
            echo '<div class="loader-11"></div>';
            break;
        case 'loader-12':
            echo '<div class="loader-12"></div>';
            break;
        case 'loader-13':
            echo '<div class="loader-13"></div>';
            break;
        case 'loader-14':
            echo '<div class="loader-14"></div>';
            break;
        case 'loader-15':
            echo '<div class="loader-15"></div>';
            break;
        case 'loader-16':
            echo '<div class="loader-16"></div>';
            break;
        case 'loader-17':
            echo '<div class="loader-17"></div>';
            break;
        case 'loader-18':
            echo '<div class="loader-18"></div>';
            break;
        case 'loader-19':
            echo '<div class="loader-19"></div>';
            break;
        case 'loader-20':
            echo '<div class="loader-20"></div>';
            break;
        case 'loader-21':
            echo '<div class="loader-21"></div>';
            break;
        case 'loader-22':
            echo '<div class="loader-22"></div>';
            break;
        case 'loader-23':
            echo '<div class="loader-23"></div>';
            break;
        case 'loader-24':
            echo '<div class="loader-24"></div>';
            break;
        case 'loader-25':
            echo '<div class="loader-25"></div>';
            break;
        case 'loader-26':
            echo '<div class="loader-26"></div>';
            break;
        case 'loader-27':
            echo '<div class="loader-27"></div>';
            break;
        case 'loader-28':
            echo '<div class="loader-28"></div>';
            break;
        case 'loader-29':
            echo '<div class="loader-29"></div>';
            break;
        case 'loader-30':
            echo '<div class="loader-30"></div>';
            break;
        case 'loader-31':
            echo '<div class="loader-31"></div>';
            break;
        case 'loader-32':
            echo '<div class="loader-32"></div>';
            break;
        case 'loader-33':
            echo '<div class="loader-33"></div>';
            break;
        case 'loader-34':
            echo '<div class="loader-34"></div>';
            break;
        case 'loader-35':
            echo '<div class="loader-35"></div>';
            break;
        case 'loader-36':
            echo '<div class="loader-36"></div>';
            break;
        case 'loader-37':
            echo '<div class="loader-37"></div>';
            break;
        case 'loader-38':
            echo '<div class="loader-38"></div>';
            break;
        case 'loader-39':
            echo '<div class="loader-39"></div>';
            break;
        case 'loader-40':
            echo '<div class="loader-40"></div>';
            break;
        case 'loader-41':
            echo '<div class="loader-41"></div>';
            break;
        case 'loader-42':
            echo '<div class="loader-42"></div>';
            break;

        default:
            // Dynamic checkagar loader name standard syntax main ho (jaise: loader-01 se loader-42 ya 1 se 42)
            $cleanName = is_numeric($name) ? sprintf('loader-%02d', $name) : $name;
            echo '<div class="' . htmlspecialchars($cleanName) . '"></div>';
            break;
    }
}
function invoiceNo($input, $pad_len = 7, $prefix = null)
{
    if ($pad_len <= strlen($input))
        trigger_error('<strong>$pad_len</strong> cannot be less than or equal to the length of <strong>$input</strong> to generate invoice number', E_USER_ERROR);

    if (is_string($prefix))
        return sprintf("%s%s", $prefix, str_pad($input, $pad_len, "0", STR_PAD_LEFT));

    return str_pad($input, $pad_len, "0", STR_PAD_LEFT);
}
?>