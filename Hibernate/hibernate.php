import java.util.List; 
import java.util.Date;
import java.util.Iterator; 
 
import org.hibernate.HibernateException; 
import org.hibernate.Session; 
import org.hibernate.Transaction;
import org.hibernate.SessionFactory;
import org.hibernate.cfg.Configuration;

public class Donators {
   private static SessionFactory factory; 
   public static void main(String[] args) {
      try{
         factory = new Configuration().configure().buildSessionFactory();
      }catch (Throwable ex) { 
         System.err.println("Failed to create sessionFactory object." + ex);
         throw new ExceptionInInitializerError(ex); 
      }
      Donators DM = new Donators();

      /* Add few donar records in database */
      Integer empID1 = DM.addDonar("Michael", "Allen", 1000);
      Integer empID2 = DM.addDonar("Daisy", "Rose", 5000);
      Integer empID3 = DM.addDonar("John", "Martinez", 10000);

      /* List down all the donars */
      DM.listDonars();

      /* Update donar's records */
      DM.updateDonar(empID1, 5000);

      /* Delete an donar from the database */
      DM.deleteDonar(empID2);

      /* List down new list of the donators */
      DM.listDonars();
   }
   /* Method to CREATE an donar in the database */
   public Integer addDonar(String fname, String lname, int salary){
      Session session = factory.openSession();
      Transaction tx = null;
      Integer donarID = null;
      try{
         tx = session.beginTransaction();
         Donar donar = new Donar(fname, lname, salary);
         donarID = (Integer) session.save(donar); 
         tx.commit();
      }catch (HibernateException e) {
         if (tx!=null) tx.rollback();
         e.printStackTrace(); 
      }finally {
         session.close(); 
      }
      return donarID;
   }
   /* Method to  READ all the employees */
   public void listDonars( ){
      Session session = factory.openSession();
      Transaction tx = null;
      try{
         tx = session.beginTransaction();
         List donars = session.createQuery("FROM Donar").list(); 
         for (Iterator iterator = 
                           donars.iterator(); iterator.hasNext();){
            Donar donar = (donar) iterator.next(); 
            System.out.print("First Name: " + donar.getFirstName()); 
            System.out.print("  Last Name: " + donar.getLastName()); 
            System.out.println("  Salary: " + donar.getSalary()); 
         }
         tx.commit();
      }catch (HibernateException e) {
         if (tx!=null) tx.rollback();
         e.printStackTrace(); 
      }finally {
         session.close(); 
      }
   }
   /* Method to UPDATE amount or 'salary' for an doanr */
   public void updateDonar(Integer DonarID, int salary ){
      Session session = factory.openSession();
      Transaction tx = null;
      try{
         tx = session.beginTransaction();
         Donar donar = 
                    (Donar)session.get(Donar.class, DonarID); 
         donar.setSalary( salary );
		 session.update(donar); 
         tx.commit();
      }catch (HibernateException e) {
         if (tx!=null) tx.rollback();
         e.printStackTrace(); 
      }finally {
         session.close(); 
      }
   }
   /* Method to DELETE an donator from the records */
   public void deleteDonar(Integer DonarID){
      Session session = factory.openSession();
      Transaction tx = null;
      try{
         tx = session.beginTransaction();
         Donar donar = 
                   (Donar)session.get(Donar.class, DonarID); 
         session.delete(donar); 
         tx.commit();
      }catch (HibernateException e) {
         if (tx!=null) tx.rollback();
         e.printStackTrace(); 
      }finally {
         session.close(); 
      }
   }
}