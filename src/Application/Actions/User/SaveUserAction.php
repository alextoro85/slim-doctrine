<?php

declare(strict_types=1);

namespace App\Application\Actions\User;

use App\Domain\User\Address\Address;
use App\Domain\User\User;
use Psr\Http\Message\ResponseInterface as Response;

class SaveUserAction extends UserAction
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $userData = $this->request->getParsedBody();

        try {
            $user = new User(null, $userData['username'], $userData['firstName'], $userData['lastName']);
        } catch (\Exception $e) {
            return $this->respondWithData($e->getMessage(), 400);
        }

        try {
            $this->userRepository->save($user);
        } catch (\Doctrine\DBAL\Exception\UniqueConstraintViolationException $e) {
            return $this->respondWithData('Username already exists', 400);
        } catch (\Exception $e) {
            return $this->respondWithData('Something went wrong on saving user', 400);
        }

        if (isset($userData['address'])) {
            try {
                $address = new Address(
                    null,
                    $user,
                    $userData['address']['street'],
                    $userData['address']['number'],
                    $userData['address']['city'],
                    $userData['address']['country']
                );
                $this->addressRepository->save($address);

                $user = $this->userRepository->findUserOfId($user->getId());
            } catch (\Exception $e) {
                return $this->respondWithData('Something went wrong on saving address', 400);
            }
        }

        $this->logger->info("User of id {$user->getId()} was saved.");

        return $this->respondWithData($user, 201);
    }
}
