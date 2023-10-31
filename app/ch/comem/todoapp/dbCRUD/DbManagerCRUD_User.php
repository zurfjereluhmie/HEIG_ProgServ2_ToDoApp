<?php

namespace ch\comem\todoapp\dbCRUD;

use ch\comem\todoapp\dbCRUD\DbManagerCRUD;
use ch\comem\todoapp\auth\User;
use Exception;

/**
 * This class extends the DbManagerCRUD class and is used for CRUD operations on the User table in the database.
 * 
 * @package ch\comem\todoapp\dbCRUD
 */
class DbManagerCRUD_User extends DbManagerCRUD
{
    static private ?DbManagerCRUD $instance = null;
    private function __construct()
    {
        parent::__construct();
    }

    /**
     * Returns an instance of the DbManagerCRUD_User class.
     *
     * @return DbManagerCRUD_User An instance of the DbManagerCRUD_User class.
     */
    static public function getInstance(): DbManagerCRUD_User
    {
        if (self::$instance === null) self::$instance = new DbManagerCRUD_User();
        return self::$instance;
    }

    public function create(object $user): int
    {
        if (!$user instanceof User) throw new Exception('Invalid object type');
        $sql = "INSERT INTO user (id, email, password, firstname, lastname) VALUES (NULL, :email, :password, :firstname, :lastname);";
        $stmt = $this->getDb()->prepare($sql);
        $stmt->execute([
            ':email' => $user->getEmail(),
            ':password' => $user->getPassword(),
            ':firstname' => $user->getFirstname(),
            ':lastname' => $user->getLastname()
        ]);
        return ($stmt->execute()) ? $this->getDb()->lastInsertId() : 0;
    }
    public function read(int $id): ?User
    {
        if (!$id) throw new Exception('Invalid id');
        $sql = "SELECT * FROM user WHERE id = :id LIMIT 1;";
        $stmt = $this->getDb()->prepare($sql);
        $stmt->execute([':id' => $id]);
        $user = $stmt->fetch();
        if (!$user) return null;

        return $this->createUser($user);
    }

    /**
     * Reads a user from the database using their email address.
     *
     * @param string $email The email address of the user to read.
     * @return object|null The user object if found, null otherwise.
     */
    public function readUsingEmail(string $email): ?object
    {
        if (!$email) throw new Exception('Invalid email');
        $sql = "SELECT * FROM user WHERE email = :email LIMIT 1;";
        $stmt = $this->getDb()->prepare($sql);
        $stmt->execute([':email' => $email]);
        $user = $stmt->fetch();
        if (!$user) return null;

        return $this->createUser($user);
    }

    /**
     * Reads a user from the database using a password reset token.
     *
     * @param string $token The password reset token to search for.
     * @return User|null The user object if found, null otherwise.
     */
    public function readUsingPWToken(string $token): ?User
    {
        if (!$token) throw new Exception('Invalid token');
        $sql = "SELECT * FROM user WHERE password_token = :password_token AND password_token_expire >= datetime() LIMIT 1;";
        $stmt = $this->getDb()->prepare($sql);
        $stmt->execute([':password_token' => $token]);
        $user = $stmt->fetch();
        if (!$user) return null;

        return $this->createUser($user);
    }

    public function update(int $id, object $user): ?object
    {
        if (!$id) throw new Exception('Invalid id');
        if (!$user instanceof User) throw new Exception('Invalid object type');

        $sql = "UPDATE user SET email = :email, password = :password, firstname = :firstname, lastname = :lastname WHERE id = :id;";
        $stmt = $this->getDb()->prepare($sql);
        $stmt->execute([
            ':email' => $user->getEmail(),
            ':password' => $user->getPassword(),
            ':firstname' => $user->getFirstname(),
            ':lastname' => $user->getLastname(),
            ':id' => $id
        ]);
        return ($stmt->execute()) ? $this->read($id) : null;
    }
    public function delete(int $id): bool
    {
        if (!$id) throw new Exception('Invalid id');
        $sql = "DELETE FROM user WHERE id = :id;";
        $stmt = $this->getDb()->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }

    /**
     * Creates a new user from the given associative array.
     *
     * @param array $user An associative array containing the user's information.
     * @return User The newly created user object.
     */
    private function createUser($user): User
    {
        return new User($user['email'], $user['password'], $user['firstname'], $user['lastname'], $user['id']);
    }
}
