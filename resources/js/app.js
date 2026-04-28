import './bootstrap';

import Alpine from 'alpinejs';
import {
    Chart,
    BarController,
    BarElement,
    CategoryScale,
    LinearScale,
    Tooltip,
    Legend
} from 'chart.js';

Chart.register(
    BarController,
    BarElement,
    CategoryScale,
    LinearScale,
    Tooltip,
    Legend
);

window.Alpine = Alpine;
window.Chart = Chart;

Alpine.start();
