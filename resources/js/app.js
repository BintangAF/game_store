// Pintu masuk JS. Satu modul = satu file di ./modules. Daftarkan modul baru di sini.
import { register, bootAll } from './core/boot';

import carousel from './modules/carousel';
import tabs from './modules/tabs';
import gallery from './modules/gallery';
import gameTip from './modules/game-tip';
import scroller from './modules/scroller';
import ticker from './modules/ticker';

register('carousel', carousel);
register('tabs', tabs);
register('gallery', gallery);
register('game-tip', gameTip);
register('scroller', scroller);
register('ticker', ticker);

document.addEventListener('DOMContentLoaded', () => bootAll());
