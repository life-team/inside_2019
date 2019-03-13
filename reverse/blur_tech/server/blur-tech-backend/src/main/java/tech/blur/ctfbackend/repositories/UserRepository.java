package tech.blur.ctfbackend.repositories;

import tech.blur.ctfbackend.models.RecoveryKey;
import tech.blur.ctfbackend.models.UserLoginPass;
import tech.blur.ctfbackend.models.User;

import java.util.Collection;

public interface UserRepository {

  User fetchUser(String id);

  User updateUser(User user);

  User authUser (UserLoginPass userLoginPass);

  void deleteUser(String id);

  User createUser(User user);

  Collection<User> getAllUsers();

  User recoveryUser(String id, RecoveryKey recoveryKey);

}