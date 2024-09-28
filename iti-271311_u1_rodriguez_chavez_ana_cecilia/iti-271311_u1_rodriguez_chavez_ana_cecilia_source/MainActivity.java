package Z.IT271311_U1_RODRIGUEZ_CHAVEZ_ANA_CECILIA;


import android.os.Bundle;
import android.view.View;
import android.widget.AdapterView;
import android.widget.Button;
import android.widget.EditText;
import android.widget.Spinner;
import android.widget.TableLayout;
import android.widget.TableRow;
import android.widget.TextView;
import android.widget.Toast;

import androidx.appcompat.app.AppCompatActivity;

public class MainActivity extends AppCompatActivity {

    EditText salaryInput, hoursPerWeekInput, daysPerWeekInput, holidaysPerYearInput, vacationDaysPerYearInput;
    Spinner salaryTypeSpinner;
    Button calculateButton;
    TableLayout resultsTable;
    double salary, hoursPerWeek, daysPerWeek, holidaysPerYear, vacationDaysPerYear;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);

        // Inicialización de vistas
        salaryInput = findViewById(R.id.salaryInput);
        salaryTypeSpinner = findViewById(R.id.salaryTypeSpinner);
        hoursPerWeekInput = findViewById(R.id.hoursPerWeekInput);
        daysPerWeekInput = findViewById(R.id.daysPerWeekInput);
        holidaysPerYearInput = findViewById(R.id.holidaysPerYearInput);
        vacationDaysPerYearInput = findViewById(R.id.vacationDaysPerYearInput);
        calculateButton = findViewById(R.id.calculateButton);
        resultsTable = findViewById(R.id.resultsTable);

        // Configurar el Listener del botón de cálculo
        calculateButton.setOnClickListener(v -> {
            if (validateInputs()) {
                String selectedSalaryType = salaryTypeSpinner.getSelectedItem().toString();
                adjustSalaryBasedOnType(selectedSalaryType); // Ajustar salario según el tipo seleccionado
                calculateSalaries(); // Calcular salarios
            } else {
                Toast.makeText(MainActivity.this, "Please fill in all fields", Toast.LENGTH_SHORT).show();
            }
        });

        // Listener para el spinner (opcional)
        salaryTypeSpinner.setOnItemSelectedListener(new AdapterView.OnItemSelectedListener() {
            @Override
            public void onItemSelected(AdapterView<?> parent, View view, int position, long id) {
                // Se puede dejar vacío si no se necesita acción aquí
            }

            @Override
            public void onNothingSelected(AdapterView<?> parent) {
            }
        });
    }

    // Validar si los inputs están completos
    private boolean validateInputs() {
        if (salaryInput.getText().toString().isEmpty() ||
                hoursPerWeekInput.getText().toString().isEmpty() ||
                daysPerWeekInput.getText().toString().isEmpty() ||
                holidaysPerYearInput.getText().toString().isEmpty() ||
                vacationDaysPerYearInput.getText().toString().isEmpty()) {
            return false;
        }
        salary = Double.parseDouble(salaryInput.getText().toString());
        hoursPerWeek = Double.parseDouble(hoursPerWeekInput.getText().toString());
        daysPerWeek = Double.parseDouble(daysPerWeekInput.getText().toString());
        holidaysPerYear = Double.parseDouble(holidaysPerYearInput.getText().toString());
        vacationDaysPerYear = Double.parseDouble(vacationDaysPerYearInput.getText().toString());
        return true;
    }

    // Ajustar el salario según el tipo seleccionado
    private void adjustSalaryBasedOnType(String selectedSalaryType) {
        double originalSalary = salary; // Salario obtenido

        switch (selectedSalaryType) {
            case "Hour":
                salary = originalSalary; // Salario por hora
                break;
            case "Day":
                salary = originalSalary / hoursPerWeek * daysPerWeek; // Salario al día
                break;
            case "Week":
                salary = originalSalary / daysPerWeek; // Salario semanal
                break;
            case "Bi-week":
                salary = (originalSalary / 2) / hoursPerWeek; // Salario por hora
                break;
            case "Semi-month":
                salary = (originalSalary / (hoursPerWeek * 3)); // Salario semi-mensual sin ajustar
                break;
            case "Month":
                salary = (originalSalary / (hoursPerWeek * 4)); // Salario mensual
                break;
            case "Quarter":
                salary = (originalSalary / (hoursPerWeek * 13)); // Salario trimestral (13 semanas)
                break;
            case "Year":
                salary = (originalSalary / (hoursPerWeek * 52)); // Salario anual
                break;
            default:
                salary = originalSalary; // Por defecto, dejar el salario como está
                break;
        }
    }

    // Función para calcular los salarios basados en las entradas
    private void calculateSalaries() {
        // Cálculos base
        double totalWorkingHoursPerYear = hoursPerWeek * 52; // Total de horas trabajadas en un año
        double totalDaysOff = holidaysPerYear + vacationDaysPerYear; // Días no laborables (feriados + vacaciones)
        double adjustedWorkingDaysPerYear = (52 * daysPerWeek) - totalDaysOff; // Días laborables ajustados
        double adjustedWorkingHoursPerYear = adjustedWorkingDaysPerYear * (hoursPerWeek / daysPerWeek);

        // Salarios sin ajustar
        double hourlySalary = salary; // Salario por hora
        double dailySalary = hourlySalary * hoursPerWeek; // Salario diario
        double weeklySalary = dailySalary * (daysPerWeek); // Salario semanal
        double biWeeklySalary = weeklySalary * 2; // Salario quincenal
        double semiMonthlySalary = (weeklySalary * 52) / 24; // Salario semi-mensual
        double monthlySalary = (weeklySalary * 52) / 12; // Salario mensual
        double quarterlySalary = monthlySalary * 3; // Salario trimestral
        double annualSalary = hourlySalary * totalWorkingHoursPerYear; // Salario anual sin ajustar

        // Salarios ajustados
        double adjustedHourlySalary = salary * (adjustedWorkingHoursPerYear / totalWorkingHoursPerYear);
        double adjustedDailySalary = adjustedHourlySalary * hoursPerWeek; // Salario ajustado diario
        double adjustedWeeklySalary = adjustedDailySalary * (daysPerWeek); // Salario ajustado semanal
        double adjustedBiWeeklySalary = adjustedWeeklySalary * 2; // Salario quincenal
        double adjustedSemiMonthlySalary = (adjustedWeeklySalary * 52) / 24; // Salario semi-mensual
        double adjustedMonthlySalary = (adjustedWeeklySalary * 52) / 12; // Salario mensual
        double adjustedQuarterlySalary = adjustedMonthlySalary * 3; // Salario trimestral
        double adjustedAnnualSalary = hourlySalary * adjustedWorkingHoursPerYear;

        resultsTable.removeViews(1, resultsTable.getChildCount() - 1);

        addTableRow("Hourly", hourlySalary, adjustedHourlySalary);
        addTableRow("Daily", dailySalary, adjustedDailySalary);
        addTableRow("Weekly", weeklySalary, adjustedWeeklySalary);
        addTableRow("Bi-weekly", biWeeklySalary, adjustedBiWeeklySalary);
        addTableRow("Semi-monthly", semiMonthlySalary, adjustedSemiMonthlySalary);
        addTableRow("Monthly", monthlySalary, adjustedMonthlySalary);
        addTableRow("Quarterly", quarterlySalary, adjustedQuarterlySalary);
        addTableRow("Annual", annualSalary, adjustedAnnualSalary);
    }

    private void addTableRow(String period, double unadjusted, double adjusted) {
        TableRow row = new TableRow(this);

        TextView periodText = new TextView(this);
        periodText.setText(period);

        TextView unadjustedText = new TextView(this);
        unadjustedText.setText(String.format("$%.2f", unadjusted));

        TextView adjustedText = new TextView(this);
        adjustedText.setText(String.format("$%.2f", adjusted));

        row.addView(periodText);
        row.addView(unadjustedText);
        row.addView(adjustedText);

        resultsTable.addView(row);
    }
}
