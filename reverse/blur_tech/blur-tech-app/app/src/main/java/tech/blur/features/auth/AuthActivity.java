package tech.blur.features.auth;


import android.content.Context;
import android.os.Bundle;
import android.view.View;
import android.view.Window;
import android.widget.Button;
import android.widget.EditText;
import android.widget.Toast;

import com.arellomobile.mvp.presenter.InjectPresenter;

import java.util.Objects;

import tech.blur.nstuctf.R;
import tech.blur.core.DefaultTextWatcher;
import tech.blur.core.PreferencesApi;
import tech.blur.core.moxy.MvpAndroidxActivity;
import tech.blur.features.objective.ObjectiveActivity;
import tech.blur.features.recovery.RecoveryActivity;

public class AuthActivity extends MvpAndroidxActivity implements AuthView {

    EditText editLogin;
    EditText editPass;
    Button buttonSignIn;

    @InjectPresenter
    AuthPresenter presenter;


    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);

        setContentView(R.layout.activity_signin);

        presenter.setPrefs(getSharedPreferences(
                PreferencesApi.sharedPreferencesName,
                Context.MODE_PRIVATE
        ));

        editLogin = findViewById(R.id.edit_signin_login);
        editPass = findViewById(R.id.edit_signin_password);
        buttonSignIn = findViewById(R.id.signIn);

        editLogin.addTextChangedListener(new DefaultTextWatcher() {
            @Override
            public void onTextChanged(CharSequence s, int start, int before, int count) {
                presenter.onLoginChanged(s.toString());
            }
        });

        editPass.addTextChangedListener(new DefaultTextWatcher() {
            @Override
            public void onTextChanged(CharSequence s, int start, int before, int count) {
                presenter.onPassChanged(s.toString());
            }
        });

        buttonSignIn.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                if (!editLogin.getText().toString().isEmpty() && !editPass.getText().toString().isEmpty())
                    presenter.onSignInClicked();
                else
                    Toast.makeText(getApplicationContext(), "Enter your account", Toast.LENGTH_SHORT).show();
            }
        });

    }

    @Override
    public void showMessage(String s) {
        Toast.makeText(getApplicationContext(), s, Toast.LENGTH_SHORT).show();
    }

    @Override
    public void openRecovery() {
        RecoveryActivity.start(this);

    }

    @Override
    public void openMainActivity(){
            ObjectiveActivity.start(this);
        }
    }
