<?php

declare(strict_types=1);

namespace Core\Http\Exceptions;

use RuntimeException;

// По идее - можно было бы реализовать HttpException, от которого унаследовать этот эксепшен
// и прочие (403, 401, 503 итд), но текущая реализация предусматривает только 404 ошибку
// (можно было бы бонусом добавить хотябы 405, но в процессе реализации я понял,
// что приложение не будет выступать в качестве API,
// поэтому даже удалил заранее подготовленный класс JsonResponse)
// Но все же оставшиеся оверхэдные методы в роутере (post, patch, put, delete) решил пока что не трогать
final class NotFoundException extends RuntimeException {}
