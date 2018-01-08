<?php
namespace App\Scanners;


use App\Builders\ScreeeShotBuilder;
use App\FirefoxProfile;
use App\ScreenShot;
use App\Site;
use App\Types\Error;
use App\webdiver\FirefoxProfileTmp;
use Carbon\Carbon;
use Facebook\WebDriver\Chrome\ChromeOptions;
use Facebook\WebDriver\Firefox\FirefoxDriver;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Illuminate\Support\Facades\Log;

class ScreenShotScanner
{


    public static function screenParams(Site $site, $update = false)
    {
        $screenshot = ScreenShot::where('site_id', $site->id)->first();
        if (empty($screenshot)) {
            $update = true;
        }
        if ($update) {
            $screenshot = new ScreenShot();
            $screenshot->site_id = $site->id;

            $name = $site->id . '_' . time() . '.png';
//            $profile = new FirefoxProfileTmp();
//            $desired_capabilities = DesiredCapabilities::firefox();
//            $desired_capabilities->setCapability(FirefoxDriver::PROFILE, $profile);

            $options = new ChromeOptions();
            $prefs = array('download.default_directory' => 'c:/temp');
            $options->setExperimentalOption('prefs', $prefs);
            $capabilities = DesiredCapabilities::chrome();
            $capabilities->setCapability(ChromeOptions::CAPABILITY, $options);
            try {
                $driver = RemoteWebDriver::create(env('SELENIUM_HOST'), $capabilities);


                $driver->get($site->main_url);
                $driver->takeScreenshot(public_path('screenshots') . DIRECTORY_SEPARATOR . $name);
                $driver->quit();
                $screenshot->screenshot = $name;
                $screenshot->updated_at = Carbon::now();
                $screenshot->save();
            } catch (Exception $ex) {
                //$response['error'] = Error::domain_screenshot_error;
                //return $response;
                throw new ScannerException(Error::domain_screenshot_error);
            }


        }
        return $screenshot;

    }

    public static function byPeriod(Site $site, $data)
    {
        $query = ScreenShot::where('site_id', $site->id);
        if (isset($data['from'])) {
            $query->where('created_at', '>=', Carbon::parse($data['from'])->toDateTimeString());
        }
        if (isset($data['to'])) {
            $query->where('created_at', '<=', Carbon::parse($data['to'])->toDateTimeString());
        }
        return $query->get();
    }

}