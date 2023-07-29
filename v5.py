import streamlit as st
import matplotlib.pyplot as plt
from matplotlib_venn import venn2
import pandas as pd
import mysql.connector

# Creating connection object
mydb = mysql.connector.connect(
    host="localhost",
    user="root",
    password="",
    database="gis_last_file")

st.header('Monitoring Application')

with st.expander('About this App'):
    st.write('''
             This app allows you to create Venn diagrams.
             Libraries used:
             - `streamlit`
             - `matplotlib`
             - `matplotlib_venn`
             - `pandas`
             - `Joseph and Mia cc `
             ''')

region_code = st.text_input('Region code')
constituency_code = st.text_input('constituency_code')
ea_code = st.text_input('EA_code')

if region_code != '' and constituency_code != '' and ea_code != '':
    region_code, constituency_code, ea_code = region_code, constituency_code, ea_code

    st.write(f"Region code: {region_code}")
    st.write(f"Constituency code: {constituency_code}")
    st.write(f"EA code: {ea_code}")

with st.sidebar:
    page = st.radio('Choose', ['2 Lists'])

# Venns Diagram - 2 Lists
if page == '2 Lists':

    col2, col1 = st.columns(2)

    with col2:
        table2 = ('listing_pes')
        col1_name = ('L_MAP_STRUCTURE')
        table1_query = "SELECT L_MAP_STRUCTURE FROM listing_pes WHERE L_REGION = '{}' AND L_CONSTITUENCY= '{}' AND L_EA = '{}'  ".format(
            region_code, constituency_code, ea_code)  # interviewer_code_1, interviewer_code_2 )
        table1_df = pd.read_sql_query(table1_query, mydb)
        list2 = table1_df['L_MAP_STRUCTURE'].tolist()

        list2_name = ('Data from FIELD')
    with col1:
        table1 = ('demarcation_data_24_july_2023_v1')
        col2_name = ('CP_STRUCTU')

        table1_query = "SELECT CP_STRUCTU FROM demarcation_data_24_july_2023_v1 WHERE REGION_CODE= '{}' AND CONSTITUENCY_CODE = '{}' AND EA_CODE = '{}'  ".format(
            region_code, constituency_code, ea_code)
        table1_df = pd.read_sql_query(table1_query, mydb)
        list1 = table1_df['CP_STRUCTU'].tolist()
        list1_name = ('Data from the GIS')

    if (list1 != []) and (list2 != []):

        st.subheader('Output')
        # Making the Venn diagram plot
        fig, ax = plt.subplots()
        venn2([set(list1), set(list2)], (list1_name, list2_name))
        plt.figure(figsize=(5, 2))
        plt.show()
        st.pyplot(fig)

        # Compute list stats
        st.subheader('List info')
        # Common elements

        common_elements = set(list1).intersection(list2)
        common_elements = list(common_elements)
        common_size = len(common_elements)

        if st.button('COMMON ELEMENTS IN GIS & FIELD'):
            st.write('Size: ', common_size)
        st.write('Elements: ', set(common_elements))

        # List differences

        duplicates = [x for x in set(list2) if list2.count(x) > 1]

        list1 = set(list1)
        list2 = set(list2)

        list1_unique = list1.difference(list2)
        list2_unique = list2.difference(list1)

        list1_size = len(list1_unique)
        list2_size = len(list2_unique)

        if st.button('UNIQUE ONLY FOUND IN GIS'):
            st.write('List 1 unique: ', list1_size)
        st.write('List 1: ', list1_unique)

        if st.button('NEW STRUCTURE'):
            st.write('List 2 unique: ', list2_size)
        st.write('List 2: ', list2_unique)
        if st.button('DUPLICATE LIST:'):
            st.write(duplicates)

        percentage = len(common_elements) / len(list1) * 100
        other_size = list2_size
       
        missed = (len(list1_unique))/(len(list1))*100
        other_size_percentage = other_size / len(list2) * 100

        st.subheader(f"The percentage of Target  ")

        # Use Streamlit to display the chart

        # Set the style and color palette for the chart

        plt.style.use('seaborn-whitegrid')
        colors = ['#FF0000', '#A67D3D', '#8CCB8C']  # Green and brown colors

        # Create a vertical bar chart to display the percentage of common elements

        fig, ax = plt.subplots()
        ax.bar(['     red   ', '      brown         ', '        green         '], [missed,
               percentage, other_size_percentage], color=colors)

        ax.set_ylabel('Percentage', fontsize=15, fontweight='bold')
        ax.set_ylim([0, 100])
        ax.set_title('Percentage of correctly recorded map structure numbers and New Structure  ',
                     fontsize=18, fontweight='bold')

        # Add percentage values to the chart

        for i, v in enumerate([missed, percentage, other_size_percentage]):
            ax.text(i, v + 1, f"{v:.1f}%", color='black', ha='center')

        # Use Streamlit to display the chart

        st.pyplot(fig)

    st.subheader('Download data')

    def download_data(input_list, list_name):
        df = pd.DataFrame()
        list_name_2 = list_name.replace(' ', '_')
        df[list_name_2] = pd.Series(list(input_list))
        csv = df.to_csv(index=False).encode('utf-8')
        st.download_button(
            label=f"{list_name} CSV",
            data=csv,
            file_name='list1.csv',
            mime='text/csv',
        )

    download_data(list1, list1_name)
    download_data(list2, list2_name)

table3 = ('listing_pes')

table3_query = "SELECT L_MAP_STRUCTURE  as Structure_Reference_number, COUNT(DISTINCT L_SN) as Duplicated FROM listing_pes WHERE L_REGION = '{}' AND L_CONSTITUENCY= '{}' AND L_EA = '{}'   GROUP BY L_MAP_STRUCTURE HAVING COUNT(DISTINCT L_SN) > 1".format(
    region_code, constituency_code, ea_code,)
table3_df = pd.read_sql_query(table3_query, mydb)
list3 = table3_df['Structure_Reference_number'].tolist()
st.write(table3_df)
import webbrowser
def redirect_to_url(url):
    webbrowser.open(url)

def main():
    

    if st.button("Logout"):
        redirect_to_url("http://localhost/online_notice_project-master/Data/logout.php")

if __name__ == "__main__":
    main()






