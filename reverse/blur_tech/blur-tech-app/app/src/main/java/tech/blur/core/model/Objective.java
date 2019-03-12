package tech.blur.core.model;


public class Objective {
    private String name;
    private String description;
    private String key;

    public Objective(String name, String description, String key) {
        this.name = name;
        this.description = description;
        this.key = key;
    }

    public String getName() {
        return name;
    }

    public String getDescription() {
        return description;
    }

    public String getKey() {
        return key;
    }
}
