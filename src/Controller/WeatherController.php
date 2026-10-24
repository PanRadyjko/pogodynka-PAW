<?php

namespace App\Controller;

use App\Entity\Location;
use App\Repository\LocationRepository;
use App\Repository\ForecastRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class WeatherController extends AbstractController
{
    #[Route('/weather/{city}', name: 'app_weather')]
    public function city(
        string $city,
        LocationRepository $locationRepository,
        ForecastRepository $forecastRepository
    ): Response {
        $location = $locationRepository->findOneBy(['city' => $city]);

        if (!$location) {
            throw $this->createNotFoundException('Nie znaleziono miasta: ' . $city);
        }

        $forecasts = $forecastRepository->findByLocation($location);

        return $this->render('weather/city.html.twig', [
            'location' => $location,
            'measurements' => $forecasts,
        ]);
    }
}
