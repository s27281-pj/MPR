import java.awt.*;
import java.util.ArrayList;
import java.util.HashSet;
import java.util.*;
import java.util.List;
import java.util.stream.Collectors;

public class Person {
    private int age;
    private String name;

    public Person(int age, String name) {
        try {
            setAge(age);
            this.name = name;
        } catch (InvalidAgeException e) {
            System.out.println("Błąd: " + e.getMessage());
        }
    }

    public Person(String name) {
        this.name = name;
    }

    public int getAge() {
        return age;
    }

    public void setAge(int age) throws InvalidAgeException {
        if (age < 0 || age > 150) {
            throw new InvalidAgeException("Nieprawidłowy wiek. Wiek powinien być między 0 a 150.");
        }
        this.age = age;
    }

    public String getName() {
        return name;
    }

    public void setName(String name) {
        this.name = name;
    }

    public static void main(String[] args) {
        // Utwórz trzy obiekty klasy Person
        Person person1 = new Person(30, "John");
        Person person2 = new Person(25, "Alice");
        Person person3 = new Person(35, "Bob");

        // Wykorzystaj List do zebrania obiektów klasy Person
        List<Person> personList = new ArrayList<>();
        personList.add(person1);
        personList.add(person2);
        personList.add(person3);

        // 4.1. Operacja reduce - Oblicz średni wiek osób w liście
        OptionalDouble averageAge = personList.stream()
                .mapToDouble(Person::getAge)
                .average();
        System.out.println("Średni wiek osób: " + averageAge.orElse(0.0));

        // 4.2. Operacja map - Stwórz nową listę z imionami osób
        List<String> namesList = personList.stream()
                .map(Person::getName)
                .collect(Collectors.toList());
        System.out.println("Lista imion osób: " + namesList);

        // 4.3. Operacja filter - Stwórz listę osób w wieku powyżej 25 lat
        List<Person> above25List = personList.stream()
                .filter(person -> person.getAge() > 25)
                .collect(Collectors.toList());
        System.out.println("Lista osób w wieku powyżej 25 lat: " + above25List);

        // 4.4. Operacja sort - Posortuj listę osób alfabetycznie według imion
        List<Person> sortedByName = personList.stream()
                .sorted(Comparator.comparing(Person::getName))
                .collect(Collectors.toList());
        System.out.println("Posortowana lista osób według imion: " + sortedByName);

        // 4.5. Operacja forEach - Wypisz imiona i wiek wszystkich osób z listy w konsoli
        System.out.println("Imiona i wiek osób:");
        personList.forEach(person -> System.out.println("Imię: " + person.getName() + ", Wiek: " + person.getAge()));

        // 4.6. Operacja min/max - Znajdź osobę o najniższym/największym wieku
        Optional<Person> youngestPerson = personList.stream()
                .min(Comparator.comparingInt(Person::getAge));
        youngestPerson.ifPresent(person -> System.out.println("Najmłodsza osoba: " + person.getName() + ", Wiek: " + person.getAge()));

        Optional<Person> oldestPerson = personList.stream()
                .max(Comparator.comparingInt(Person::getAge));
        oldestPerson.ifPresent(person -> System.out.println("Najstarsza osoba: " + person.getName() + ", Wiek: " + person.getAge()));
    }
}