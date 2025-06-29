<?php

/*
в задаче сказано, 
что нужно возвратить количество сестер, а не братьев+сестер, 
поэтому я не понял зачем тут параметр количества братьев
*/
function aliceBrotherSistersCount($aliceSistersCount) {
    return $aliceSistersCount - 1;
}

