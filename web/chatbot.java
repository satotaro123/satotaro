package chatbot;

import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;

public class chatbot {

    public static void main(String[] args) {
        Connection conn = null;
        try {
            // JDBCドライバの登録
            Class.forName("org.postgresql.Driver");

            // データベースへ接続
            conn = DriverManager.getConnection(
            	"postgres://hjxiibzzbialkm:227ba653a1200a8a8bf40645763da904bfca62e1ee9e64b6f68ca2f7824da99d@ec2-54-83-26-65.compute-1.amazonaws.com:5432/daj2h828dej8bv","hjxiibzzbialkm","227ba653a1200a8a8bf40645763da904bfca62e1ee9e64b6f68ca2f7824da99d");

            // SQL文を準備
            String sql = "SELECT * FROM cvsdata";
            PreparedStatement pStmt = conn.prepareStatement(sql);

            // SQL文を実行し、結果表を取得
            ResultSet rs = pStmt.executeQuery ();

            // 結果表に格納されたレコードの内容を表示
            while(rs.next()){

            	String userid = rs.getString("userID");
            //取得したデータの出力
            	System.out.println(userid);
            }

        }catch(SQLException e){
        	e.printStackTrace();
        }catch(ClassNotFoundException e){
        	e.printStackTrace();
        } finally{
        	//データベース切断
        	if(conn !=null){
        		try{
        			conn.close();
        		}catch(SQLException e){
        			e.printStackTrace();
        		}
        	}
        }
    }

}