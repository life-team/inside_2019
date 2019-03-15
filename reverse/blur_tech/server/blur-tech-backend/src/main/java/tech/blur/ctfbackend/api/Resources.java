package tech.blur.ctfbackend.api;

import java.util.ArrayList;

/**
 * Класс с константами для API
 */
public class Resources {

  public static final String API_PREFIX = "";
  public static final String TOKEN = "4aJ7xdJ93kXKGOtzkb06";

  private static ArrayList<String> tokens = new ArrayList<>();

  public static String getToken(int id){
    return tokens.get(id);
  }

  public static void setToken(String pass){
    tokens.add(Resources.TOKEN + pass);
  }

  public static boolean isThereToken(String token){
    return tokens.contains(token);
  }
}
