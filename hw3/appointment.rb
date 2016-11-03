class Appointment
    attr_accessor :description, :day, :month, :year
    attr_reader :appType

    def occursOn(day, month, year)
        raise 'Not implemented'
    end

    #
    # Class members
    #
    @@subclass_registar = {}

    def self.registerClass(clazz)
        @@subclass_registar[clazz] = self
    end

    def self.getInstance(clazz)
        clazz = @@subclass_registar[clazz]
        if clazz
            clazz.new
        else
            raise "Error: No such type"
        end
    end
end


class OneTime < Appointment

    def occursOn(day, month, year)
        if @day == day && @month == month && @year == year
            return true
        end
        false
    end

    # register subtype
    registerClass(:OneTime)

end

class Day < Appointment

    def occursOn(day, month, year)
        if @day == day
            return true
        end
        false
    end

    # register subtype
    registerClass(:Day)
end

class Month < Appointment

    def occursOn(day, month, year)
        if @month == month
            return true
        end
        false
    end

    # register subtype
    registerClass(:Month)
end
