package tech.blur.ctfbackend.models;


import lombok.AllArgsConstructor;
import lombok.Data;
import lombok.NoArgsConstructor;

@NoArgsConstructor
@Data
@AllArgsConstructor
public class Objective {
    private String name;
    private String description;
    private String key;

}
