package com.example.eventsfinder;

public class Events {
    private int id;
    private String event_name;
    private String location;
    private String event_type;
    private double latitude;
    private double longitude;
    private String schedule_date;
    private String schedule_time;
    private String description;
    private String image;

    public Events(int id, String event_name, String location, String event_type, double latitude, double longitude, String schedule_date, String schedule_time, String description, String image) {
        this.id = id;
        this.event_name = event_name;
        this.location = location;
        this.event_type = event_type;
        this.latitude = latitude;
        this.longitude = longitude;
        this.schedule_date = schedule_date;
        this.schedule_time = schedule_time;
        this.description = description;
        this.image = image;
    }

    public int getId() {
        return id;
    }

    public String getEvent_name() {
        return event_name;
    }

    public String getLocation() {
        return location;
    }

    public String getEvent_type() {
        return event_type;
    }

    public double getLatitude() {
        return latitude;
    }

    public double getLongitude() {
        return longitude;
    }

    public String getSchedule_date() {
        return schedule_date;
    }

    public String getSchedule_time() {
        return schedule_time;
    }

    public String getDescription() {
        return description;
    }

    public String getImage() {
        return image;
    }

    public void setId(int id) {
        this.id = id;
    }

    public void setEvent_name(String event_name) {
        this.event_name = event_name;
    }

    public void setLocation(String location) {
        this.location = location;
    }

    public void setEvent_type(String event_type) {
        this.event_type = event_type;
    }

    public void setLatitude(double latitude) {
        this.latitude = latitude;
    }

    public void setLongitude(double longitude) {
        this.longitude = longitude;
    }

    public void setSchedule_date(String schedule_date) {
        this.schedule_date = schedule_date;
    }

    public void setSchedule_time(String schedule_time) {
        this.schedule_time = schedule_time;
    }

    public void setDescription(String description) {
        this.description = description;
    }

    public void setImage(String image) {
        this.image = image;
    }
}
