<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Area;
use App\Entity\City;
use App\Entity\Country;
use App\Entity\User;
use App\Form\ProfileBiographyForm;
use App\Form\ProfileGeneralForm;
use App\Repository\CityRepository;
use App\Repository\CountryRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Exception;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class ProfileService
{
    private $em;

    /** @var UserRepository $userRepository */
    private $userRepository;

    /** @var FormFactoryInterface $formFactory */
    private $formFactory;

    /** @var UrlGeneratorInterface */
    private $router;

    public function __construct(
        EntityManagerInterface $em,
        FormFactoryInterface $formFactory,
        UrlGeneratorInterface $router
    ) {
        $this->em = $em;
        $this->userRepository = $em->getRepository(User::class);
        $this->formFactory = $formFactory;
        $this->router = $router;
    }

    public function getAvailableCountries()
    {
        return $this->getCountryRepository()->findBy(['enabled' => true]);
    }

    public function getAvailableCities()
    {
        return $this->getCityRepository()->findBy(['enabled' => true]);
    }

    private function getCountryRepository(): CountryRepository
    {
        return $this->em->getRepository(Country::class);
    }

    private function getCityRepository(): CityRepository
    {
        return $this->em->getRepository(City::class);
    }

    /**
     * @param User $user
     *
     * @throws ORMException
     *
     * @throws OptimisticLockException
     */
    public function updateUserData(User $user)
    {
        $this->userRepository->save($user);
    }

    /** @return Country[] */
    public function getCountryChoices()
    {
        return $this->em->getRepository(Country::class)->findBy([], ['name' => 'ASC']);
    }

    /** @return City[] */
    public function getCityChoices()
    {
        return $this->em->getRepository(City::class)->findBy([], ['name' => 'ASC']);
    }

    /** @return Area[] */
    public function getAreaChoices()
    {
        return $this->em->getRepository(Area::class)->findBy([], ['name' => 'ASC']);
    }

    private function getEditFormParts(): array
    {
        return ['general' => ProfileGeneralForm::class, 'biography' => ProfileBiographyForm::class];
    }

    /**
     * @param UserInterface $user
     *
     * @return array
     */
    public function generateEditFormsViews(UserInterface $user): array
    {
        $fromParts = $this->getEditFormParts();
        foreach ($fromParts as $key => $formPart) {
            $fromParts[$key] = $this->formFactory->createNamed(
                $key,
                $formPart,
                $user,
                [
                    'action' => $this->router->generate('profile_edit'),
                ]
            )->createView();
        }

        return $fromParts;
    }

    /**
     * @param array         $requestParameters
     * @param UserInterface $user
     *
     * @return FormInterface
     *
     * @throws Exception
     */
    public function handleFormEdit(array $requestParameters, UserInterface $user): FormInterface
    {
        $formParts = $this->getEditFormParts();
        $formName = array_key_first($requestParameters);
        if (!array_key_exists($formName, $formParts)) {
            throw new Exception('Invalid form name');
        }

        return $this->formFactory->createNamed($formName, $formParts[$formName], $user);
    }
}
