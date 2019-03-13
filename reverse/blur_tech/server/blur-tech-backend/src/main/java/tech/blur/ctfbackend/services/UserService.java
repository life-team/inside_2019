package tech.blur.ctfbackend.services;

import tech.blur.ctfbackend.models.RecoveryKey;
import tech.blur.ctfbackend.models.UserLoginPass;
import tech.blur.ctfbackend.models.User;
import tech.blur.ctfbackend.repositories.UserRepository;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;

import java.util.Collection;

@Service
public class UserService {

  private final UserRepository userRepository;

  @Autowired
  public UserService(final UserRepository userRepository) {
    this.userRepository = userRepository;
  }

  public User provideUser(String id) {
    return userRepository.fetchUser(id);
  }

  public User updateUser(User user) {
    userRepository.updateUser(user);
    return user;
  }

  public void deleteUser(String id) {
    userRepository.deleteUser(id);
  }

  public User authUser (UserLoginPass userLoginPass){
    return userRepository.authUser(userLoginPass);
  }

  public User recoverUser(String id, RecoveryKey recoveryKey){
    return userRepository.recoveryUser(id, recoveryKey);
  }

  public User createUser(User user) {
    userRepository.createUser(user);
    return user;
  }

  public Collection<User> provideUsers() {
    return userRepository.getAllUsers();
  }

}
