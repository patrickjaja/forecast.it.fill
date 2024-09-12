<?php

declare(strict_types=1);

/*
 * This file is part of forecast.it.fill project.
 * (c) Patrick Jaja <patrickjajaa@gmail.com>
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace ForecastAutomation\ProjektronClient;

use ForecastAutomation\Activity\Shared\Dto\ActivityDtoCollection;
use ForecastAutomation\Kernel\AbstractFacade;
use ForecastAutomation\ProjektronClient\Business\PayloadDTO;

/**
 * @method \ForecastAutomation\JiraClient\JiraClientFactory getFactory()
 */
class ProjektronClientFacade extends AbstractFacade
{
    private $url;
    private $headers;
    private $payloadDTO;

    public function send() {
        $this->url = 'https://projektron.valantic.com/bcs/taskdetail/effortrecording/edit?oid=1701894153411_JTask';
        $this->headers = [
            'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.7',
            'Accept-Language: de-DE,de;q=0.9,en-US;q=0.8,en;q=0.7',
            'Cache-Control: no-cache',
            'Connection: keep-alive',
            'Content-Type: application/x-www-form-urlencoded',
            'Cookie: _gcl_au=1.1.1981414287.1723202755; __qca=P0-1366456151-1723202755461; OAuthCSRFState=9JN6PUckKBwKzJXLPJt-hxcI1mD5dO2LG2G7fSL1z4A; TABLET=false; COLOR_SCHEME=Light; JSESSIONID=F73E27B955FC0B5C37FFC09E3234C8FD; BROWSER_ENCRYPTION_KEY=vtzQfWGcFnlGthQeytSHMA4JK7KsRufo88WdH+Wq0WQ=; CSRF_Token=B54W-Zkk-aHq9JDFzCIUtOOBjbTYrKmDxRJrh1Ofpck',
            'Origin: null',
            'Pragma: no-cache',
            'Sec-Fetch-Dest: document',
            'Sec-Fetch-Mode: navigate',
            'Sec-Fetch-Site: same-origin',
            'Sec-Fetch-User: ?1',
            'Upgrade-Insecure-Requests: 1',
            'User-Agent: Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.0.0 Safari/537.36',
            'sec-ch-ua: "Chromium";v="128", "Not;A=Brand";v="24", "Google Chrome";v="128"',
            'sec-ch-ua-mobile: ?0',
            'sec-ch-ua-platform: "Linux"'
        ];
        $this->payloadDTO = new PayloadDTO();

        $ch = curl_init($this->url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $this->payloadDTO->getEncodedData());
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);
        if (curl_errno($ch)) {
            throw new Exception(curl_error($ch));
        }
        curl_close($ch);

        return $response;
    }

    public function writeActivities(ActivityDtoCollection $activityDtoCollection): int
    {
//        https://projektron.valantic.com/bcs/login
        $this->send();
        $test = $activityDtoCollection;
        return 10;
    }
}
