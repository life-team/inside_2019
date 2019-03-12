package tech.blur.core;

import android.content.SharedPreferences;

import com.google.gson.Gson;
import tech.blur.core.model.User;

public class PreferencesApi {

    public static final String sharedPreferencesName = "tech.blur.prefs";
    private enum PrefsNames {JWT, USER}

    public static void setJwt (String jwt, SharedPreferences prefs){
        prefs.edit().putString(PrefsNames.JWT.name(), jwt).apply();
    }

    public static String getJwt (SharedPreferences prefs){
        return prefs.getString(PrefsNames.JWT.name(), null);
    }

    public static void setUser (User user, SharedPreferences prefs){
        Gson gson = new Gson();
        String json = gson.toJson(user);
        prefs.edit().putString(PrefsNames.USER.name(), json).apply();
    }

    public static User getUser (SharedPreferences prefs){
        Gson gson = new Gson();
        String json = prefs.getString(PrefsNames.USER.name(), null);
        return gson.fromJson(json, User.class);
    }
}
